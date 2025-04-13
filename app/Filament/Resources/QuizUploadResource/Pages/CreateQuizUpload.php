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
    
        foreach ($phpWord->getSections() as $section) {
            $inQuestionSection = false;
            $questionText = '';
            $options = [];
            $answer = null;
    
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                            $line = trim($textElement->getText());
    
                            if ($line === '') continue;
    
                            Log::info("Processing line: " . $line);
    
                            // Check if the line is a question
                            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                                if ($currentQuestion !== null) {
                                    // Save the previous question
                                    $questions[] = $currentQuestion;
                                }
                                $currentQuestion = [
                                    'question' => $matches[1],
                                    'options' => [],
                                    'answer' => null,
                                ];
                                $inQuestionSection = true;
                                $questionText = $matches[1];
                            } elseif (preg_match('/^([A-E])\.\s*(.+)/', $line, $matches) && $inQuestionSection) {
                                $options[$matches[1]] = $matches[2];
                            } elseif (preg_match('/^Jawaban\s*[:\-]?\s*([A-E])\.?/i', $line, $matches) && $inQuestionSection) {
                                $answer = strtoupper($matches[1]);
                                $inQuestionSection = false; // End of question section
                            }
                        }
                    }
                }
            }
    
            // Check if there's a question at the end of the section
            if ($inQuestionSection && $currentQuestion !== null) {
                $currentQuestion['options'] = $options;
                $currentQuestion['answer'] = $answer;
                $questions[] = $currentQuestion;
                $currentQuestion = null;
            }
        }
    
        Log::info("Questions parsed: " . json_encode($questions));
    
        foreach ($questions as $q) {
            try {
                $question = Question::create([
                    'quiz_id' => $quizId,
                    'question' => $q['question'],
                    'image' => null,
                ]);
    
                Log::info("Question created with ID: " . $question->id);
    
                foreach ($q['options'] as $key => $text) {
                    $option = Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'option_image' => null,
                        'is_correct' => $key === $q['answer'],
                        'explanation' => null,
                    ]);
    
                    Log::info("Option created with ID: " . $option->id);
                }
            } catch (\Exception $e) {
                Log::error('Error saving question and options: ' . $e->getMessage());
            }
        }
    
        Log::info("Successfully imported " . count($questions) . " questions into quiz ID: {$quizId}");
    }

}
