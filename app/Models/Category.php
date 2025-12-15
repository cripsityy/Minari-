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
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-category.jpg');
    }

    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : asset('images/default-header.jpg');
    }
}