<?php

namespace App\Filament\Resources\QuizUploadResource\Pages;

use App\Filament\Resources\QuizUploadResource;
use App\Models\Question;
use App\Models\Option;
use Filament\Resources\Pages\CreateRecord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\WordQuizImporter;
use PhpOffice\PhpWord\Element\Image as PhpWordImage;

class CreateQuizUpload extends CreateRecord
{
    protected static string $resource = QuizUploadResource::class;

    protected function afterCreate(): void {
        $quiz = $this->record;
        $filePath = $quiz->file; // relative path dari storage/app

        Log::info("Quiz file path: " . $filePath);

        $this->processQuizFromWord($filePath, $quiz->id);
    }

    protected function processQuizFromWord(string $filePath, int $quizId): void {
        $realPath = storage_path("app/{$filePath}");
    
        if (!file_exists($realPath)) {
            Log::error("File not found: {$realPath}");
            return;
        }
    
        $phpWord = IOFactory::load($realPath);
        $questions = [];
        $currentQuestion = null;
        $options = [];
        $answer = null;
        $explanation = null;
        $questionImage = null;
        $optionImages = [];
    
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    $textLine = '';
                    foreach ($element->getElements() as $textElement) {
                        if (method_exists($textElement, 'getText')) {
                            $textLine .= $textElement->getText(); // Collect all text, regardless of formatting
                        }
                    }
    
                    $line = trim($textLine);
                    if ($line === '') continue;
    
                    Log::info("Processing line: " . $line);
    
                    // Check if the line is a question
                    if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                        if ($currentQuestion) {
                            $currentQuestion['options'] = $options;
                            $currentQuestion['answer'] = $answer;
                            $currentQuestion['explanation'] = $explanation; // Store the explanation
                            $currentQuestion['image'] = $questionImage; // Store the question image
                            $questions[] = $currentQuestion;
                        }
    
                        $currentQuestion = [
                            'question' => $matches[1],
                            'options' => [],
                            'answer' => null,
                            'explanation' => null,
                            'image' => null,
                        ];
                        $options = [];
                        $answer = null;
                        $explanation = null;
                        $questionImage = null;
                        $optionImages = [];
    
                    } elseif (preg_match('/^([A-E])\.\s*(.+)/', $line, $matches)) {
                        $options[$matches[1]] = $matches[2];
                        $optionImages[$matches[1]] = null;
    
                    } elseif (preg_match('/^Jawaban\s*[:\-]?\s*([A-E])\.?/i', $line, $matches)) {
                        $answer = strtoupper(trim($matches[1]));
    
                    } elseif (preg_match('/^Penjelasan\s*[:\-]?\s*(.+)/i', $line, $matches)) {
                        $explanation = trim($matches[1]); // Capture the explanation
                    }
                } elseif ($element instanceof PhpWordImage) {
                    // Handle image
                    $imageSrc = $element->getSource(); // Get the source path of the image
                    if ($currentQuestion && !$questionImage) {
                        // Save question image
                        $questionImage = $this->saveImage($imageSrc, 'questions');
                    } else {
                        // Save option image
                        foreach ($options as $key => $option) {
                            if (!$optionImages[$key]) {
                                $optionImages[$key] = $this->saveImage($imageSrc, 'options');
                                break;
                            }
                        }
                    }
                }
            }
    
            // Add the last question
            if ($currentQuestion) {
                $currentQuestion['options'] = $options;
                $currentQuestion['answer'] = $answer;
                $currentQuestion['explanation'] = $explanation;
                $currentQuestion['image'] = $questionImage;
                $questions[] = $currentQuestion;
                $currentQuestion = null;
            }
        }
    
        Log::info("Questions parsed: " . json_encode($questions));
    
        // Save to database
        foreach ($questions as $q) {
            try {
                $question = Question::create([
                    'quiz_id' => $quizId,
                    'question' => $q['question'],
                    'image' => $q['image'],
                ]);
    
                foreach ($q['options'] as $key => $text) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'option_image' => $optionImages[$key],
                        'is_correct' => $key === $q['answer'],
                        'explanation' => ($key === $q['answer']) ? $q['explanation'] : null, // Explanation only for correct option
                    ]);
                }
    
                Log::info("Question created: {$question->id}");
    
            } catch (\Exception $e) {
                Log::error('Error saving question and options: ' . $e->getMessage());
            }
        }
    
        Log::info("Successfully imported " . count($questions) . " questions into quiz ID: {$quizId}");
    }
    
    protected function saveImage($imagePath, $folder) {
        $destinationPath = storage_path("app/{$folder}");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
    
        $filename = basename($imagePath);
        $newImagePath = $destinationPath . '/' . $filename;
        copy($imagePath, $newImagePath);
    
        return $filename;
    }

    // protected function afterSave(): void {
    //     if ($this->record->file_path) {
    //         app(WordQuizImporter::class)->process(
    //             $this->record->file_path,
    //             $this->record->quiz_id
    //         );
    //     }
    // }

}
