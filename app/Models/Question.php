<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'question',
        'image',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
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

        $directory = 'questions/image';
        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Create the directory if it doesn't exist
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Store the image
        $image->storeAs($directory, $filename, 'public');

        // Update the image attribute
        $this->image = $path;
        $this->save();
    }

    public function getImageUrlAttribute()
    {
        // Check if there is an uploaded image
        if ($this->image) {
            // Return a valid image URL
            return Storage::url($this->image);
        }

        // If there is no uploaded image, return a default URL or handle it as needed
        return null;
    }
}