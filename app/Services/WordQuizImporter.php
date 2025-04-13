<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;

class WordQuizImporter
{
    public function import(string $filePath, int $quizId): void {
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
        $explanation = null; // inisialisasi di awal

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (!($element instanceof \PhpOffice\PhpWord\Element\TextRun)) continue;

                $textLine = '';
                foreach ($element->getElements() as $textElement) {
                    if (method_exists($textElement, 'getText')) {
                        $textLine .= $textElement->getText();
                    }
                }

                $line = trim($textLine);
                if ($line === '') continue;

                Log::info("Processing line: " . $line);

                if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                    if ($currentQuestion) {
                        $currentQuestion['options'] = $options;
                        $currentQuestion['answer'] = $answer;
                        $currentQuestion['explanation'] = $explanation;
                        $questions[] = $currentQuestion;

                        // reset variabel
                        $currentQuestion = null;
                        $options = [];
                        $answer = null;
                        $explanation = null;
                    }

                    $currentQuestion = [
                        'question' => $matches[1],
                        'options' => [],
                        'answer' => null,
                        'explanation' => null,
                    ];

                } elseif (preg_match('/^([A-Ea-e])\.\s*(.+)/', $line, $matches)) {
                    $options[strtoupper($matches[1])] = $matches[2];

                } elseif (preg_match('/^Jawaban\s*[:\-]?\s*([A-Ea-e])\.?/i', $line, $matches)) {
                    $answer = strtoupper(trim($matches[1]));

                } elseif (preg_match('/^Penjelasan\s*[:\-]?\s*(.+)/i', $line, $matches)) {
                    $explanation = trim($matches[1] ?? '');
                }
            }

            // tambahkan soal terakhir
            if ($currentQuestion) {
                $currentQuestion['options'] = $options;
                $currentQuestion['answer'] = $answer;
                $currentQuestion['explanation'] = $explanation;
                $questions[] = $currentQuestion;

                // reset
                $currentQuestion = null;
                $options = [];
                $answer = null;
                $explanation = null;
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

                foreach ($q['options'] as $key => $text) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'option_image' => null,
                        'is_correct' => $key === $q['answer'],
                        'explanation' => $key === $q['answer'] ? $q['explanation'] : null,
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
