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
        $options = [];
        $answer = null;
    
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (!($element instanceof \PhpOffice\PhpWord\Element\TextRun)) continue;
    
                $textLine = '';
                foreach ($element->getElements() as $textElement) {
                    if (method_exists($textElement, 'getText')) {
                        $textLine .= $textElement->getText(); // Ambil semua teks, tidak peduli format
                    }
                }
    
                $line = trim($textLine);
                if ($line === '') continue;
    
                Log::info("Processing line: " . $line);
    
                // Cek apakah baris adalah soal
                if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                    if ($currentQuestion) {
                        $currentQuestion['options'] = $options;
                        $currentQuestion['answer'] = $answer;
                        $questions[] = $currentQuestion;
                    }
    
                    $currentQuestion = [
                        'question' => $matches[1],
                        'options' => [],
                        'answer' => null,
                    ];
                    $options = [];
                    $answer = null;
    
                } elseif (preg_match('/^([A-E])\.\s*(.+)/', $line, $matches)) {
                    $options[$matches[1]] = $matches[2];
    
                } elseif (preg_match('/^Jawaban\s*[:\-]?\s*([A-E])\.?/i', $line, $matches)) {
                    $answer = strtoupper(trim($matches[1]));
                }
            }
    
            // Tambahkan pertanyaan terakhir
            if ($currentQuestion) {
                $currentQuestion['options'] = $options;
                $currentQuestion['answer'] = $answer;
                $questions[] = $currentQuestion;
                $currentQuestion = null;
            }
        }
    
        Log::info("Questions parsed: " . json_encode($questions));
    
        // Simpan ke database
        foreach ($questions as $q) {
            try {
                $question = Question::create([
                    'quiz_id' => $quizId,
                    'question' => $q['question'],
                    'image' => null,
                ]);
    
                foreach ($q['options'] as $key => $text) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'option_image' => null,
                        'is_correct' => $key === $q['answer'],
                        'explanation' => null,
                    ]);
                }
    
                Log::info("Question created: {$question->id}");
    
            } catch (\Exception $e) {
                Log::error('Error saving question and options: ' . $e->getMessage());
            }
        }
    
        Log::info("Successfully imported " . count($questions) . " questions into quiz ID: {$quizId}");
    }    

}
