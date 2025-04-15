<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Option extends Model
{
    use HasFactory;

    protected $table = 'options';

    protected $fillable = [
        'question_id',
        'option_text',
        'option_image',
        'is_correct',
        'explanation'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($option) {
            // Delete the associated image from storage
            if ($option->option_image) {
                Storage::disk('public')->delete($option->option_image);
            }
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function storeImage($image)
    {
        // Define allowed image types and size limit
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2048 * 1024; // 2MB in bytes

        // Validate image type
        if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
            throw new \InvalidArgumentException('Invalid image type. Allowed types: ' . implode(', ', $allowedMimeTypes));
        }

        // Validate image size
        if ($image->getSize() > $maxFileSize) {
            throw new \InvalidArgumentException('Image size exceeds the maximum allowed size of ' . ($maxFileSize / 1024 / 1024) . 'MB');
        }

        $directory = 'options/images';
        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Create the directory if it doesn't exist
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Store the image
        $image->storeAs($directory, $filename, 'public');

        // Update the option_image attribute
        $this->option_image = $path;
        $this->save();
    }

    public function getImageUrlAttribute()
    {
        // Check if there is an uploaded image
        if ($this->option_image) {
            // Return a valid image URL
            return Storage::url($this->option_image);
        }

        // If there is no uploaded image, return a default URL or handle it as needed
        return null;
    }
}