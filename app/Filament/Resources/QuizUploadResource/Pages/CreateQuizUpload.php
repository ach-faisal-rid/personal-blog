<?php

namespace App\Filament\Resources\QuizUploadResource\Pages;

use App\Filament\Resources\QuizUploadResource;
use App\Models\Question;
use App\Models\Option;
use Filament\Resources\Pages\CreateRecord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateQuizUpload extends CreateRecord
{
    protected static string $resource = QuizUploadResource::class;

    protected function afterCreate(): void
    {
        $quiz = $this->record;
        $filePath = $quiz->file;

        $this->processQuizFromWord($filePath, $quiz->id);
    }

    protected function processQuizFromWord(string $filePath, int $quizId): void
    {
        $realPath = Storage::disk('public')->path($filePath);

        if (!file_exists($realPath)) {
            throw new \Exception("File not found: {$realPath}");
        }

        $phpWord = IOFactory::load($realPath);
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
                            $textLine .= $textElement->getText();
                        }
                    }

                    $line = trim($textLine);
                    if ($line === '') continue;

                    // Detect question
                    if (preg_match('/^(\d+)\.\s*(.*)/', $line, $matches)) {
                        if ($currentQuestion) {
                            // Save the previous question
                            $currentQuestion['options'] = $options;
                            $currentQuestion['answer'] = $answer;
                            $currentQuestion['explanation'] = $explanation;
                            $currentQuestion['optionImages'] = $optionImages;

                            // Save the previous question to the database
                            $this->saveQuestion($currentQuestion, $quizId);
                        }

                        // Start new question with the number and text
                        $currentQuestion = [
                            'question' => $matches[1] . '. ' . $matches[2],
                            'options' => [],
                            'answer' => null,
                            'explanation' => null,
                            'image' => $questionImage,
                            'optionImages' => [],
                        ];
                        $options = [];
                        $answer = null;
                        $explanation = null;
                        $questionImage = null;
                        $optionImages = [];
                    }
                    // Detect option (A–E)
                    elseif (preg_match('/^([A-E])\.\s*(.*)/', $line, $matches)) {
                        $options[$matches[1]] = $matches[1] . '. ' . $matches[2];
                        $optionImages[$matches[1]] = null;
                    }

                    // Detect answer
                    elseif (preg_match('/^Jawaban\s*[:\-]?\s*([A-E])\.?/i', $line, $matches)) {
                        $answer = strtoupper(trim($matches[1]));
                    }

                    // Detect explanation
                    elseif (preg_match('/^Penjelasan\s*[:\-]?\s*(.*)/i', $line, $matches)) {
                        $explanation = trim($matches[1]);
                    }
                }
                // Detect image
                elseif ($element instanceof \PhpOffice\PhpWord\Element\Image) {
                    $imageSrc = $element->getSource();
                    if ($currentQuestion && !$questionImage) {
                        $questionImage = $this->saveImage($imageSrc, 'questions');
                    } else {
                        foreach ($options as $key => $option) {
                            if (!isset($optionImages[$key])) {
                                $optionImages[$key] = $this->saveImage($imageSrc, 'options');
                                break;
                            }
                        }
                    }
                }
            }
        }

        // Save the last question after the loop is done
        if ($currentQuestion) {
            $currentQuestion['options'] = $options;
            $currentQuestion['answer'] = $answer;
            $currentQuestion['explanation'] = $explanation;
            $currentQuestion['optionImages'] = $optionImages;

            $this->saveQuestion($currentQuestion, $quizId);
        }
    }

    protected function saveQuestion(array $questionData, int $quizId): void
    {
        if (empty($questionData['question'])) {
            throw new \Exception("Skipping question because it is empty");
        }

        $question = Question::create([
            'quiz_id' => $quizId,
            'question' => $questionData['question'],
            'image' => $questionData['image'] ?? null,
        ]);

        if (empty($questionData['options']) || !is_array($questionData['options'])) {
            throw new \Exception("Skipping question ID {$question->id} because it has no options");
        }

        foreach ($questionData['options'] as $key => $text) {
            if (empty($text)) continue;

            Option::create([
                'question_id' => $question->id,
                'option_text' => $text,
                'option_image' => $questionData['optionImages'][$key] ?? null,
                'is_correct' => strtoupper($key) === strtoupper($questionData['answer']),
                'explanation' => (strtoupper($key) === strtoupper($questionData['answer'])) ? $questionData['explanation'] : null,
            ]);
        }
    }

    protected function saveImage($imagePath, $folder): ?string
    {
        // Create folder if not exists
        $destinationPath = storage_path("app/public/{$folder}");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Get image extension
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $filename = Str::random(40) . '.' . $extension;
        $newImagePath = $destinationPath . '/' . $filename;

        // Copy image to the destination folder
        if (!copy($imagePath, $newImagePath)) {
            throw new \Exception("Failed to copy image: {$imagePath} to {$newImagePath}");
        }

        return "public/{$folder}/{$filename}";
    }
}