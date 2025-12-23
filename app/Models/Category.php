<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'background_image',
        'status'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return asset('images/default-category.jpg');
        
        // 1. If it's a full URL, return it
        if (filter_var($this->image, FILTER_VALIDATE_URL)) return $this->image;

        // 2. Check if file exists locally (Legacy/Volume)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        // 3. Try Cloudinary (Hybrid Fallback)
        if (env('CLOUDINARY_URL')) {
            try {
                return \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($this->image);
            } catch (\Exception $e) {
                // Return local path as fail-safe or placeholder
                return asset('storage/' . $this->image);
            }
        }
        
        return asset('storage/' . $this->image);
    }

    public function getBackgroundImageUrlAttribute()
    {
        if (!$this->background_image) return asset('images/default-header.jpg');
        
        if (filter_var($this->background_image, FILTER_VALIDATE_URL)) return $this->background_image;

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->background_image)) {
            return asset('storage/' . $this->background_image);
        }

        if (env('CLOUDINARY_URL')) {
            try {
                return \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($this->background_image);
            } catch (\Exception $e) {
                return asset('storage/' . $this->background_image);
            }
        }
        
        return asset('storage/' . $this->background_image);
    }
}