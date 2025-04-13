<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'description',
        'file'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($quiz) {
            // Delete the associated file from storage
            if ($quiz->file) {
                Storage::disk('local')->delete($quiz->file);
            }
        });
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function storeFile($file)
    {
        $directory = 'quiz-docs';
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Create the directory if it doesn't exist
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Store the file
        $file->storeAs($directory, $filename, 'public');

        // Update the file attribute
        $this->file = $path;
        $this->save();
    }

    public function getFileUrlAttribute()
    {
        // Check if there is an uploaded file
        if ($this->file) {
            // Return a valid file URL
            return url('storage/' . $this->file);
        }

        // If there is no uploaded file, return a default URL or handle it as needed
        return null;
    }
}