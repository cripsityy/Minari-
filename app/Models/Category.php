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
        if (filter_var($this->image, FILTER_VALIDATE_URL)) return $this->image;
        if (env('CLOUDINARY_URL')) return \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($this->image);
        return asset('storage/' . $this->image);
    }

    public function getBackgroundImageUrlAttribute()
    {
        if (!$this->background_image) return asset('images/default-header.jpg');
        if (filter_var($this->background_image, FILTER_VALIDATE_URL)) return $this->background_image;
        if (env('CLOUDINARY_URL')) return \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($this->background_image);
        return asset('storage/' . $this->background_image);
    }
}