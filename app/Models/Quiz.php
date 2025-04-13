<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
}
