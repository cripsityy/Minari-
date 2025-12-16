<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'sku',
        'color',
        'material',
        'image',
        'images',
        'category_id',
        'status',
        'sold_count',
        'view_count'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?: $this->price;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.jpg');
    }

    public function getImagesUrlsAttribute()
    {
        if (!$this->images) return [asset('images/default-product.jpg')];
        
        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('status', 'approved')->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->where('status', 'approved')->count();
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->discount_price) return 0;
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('stock', '>', 0);
    }

    public function scopeNewArrival($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    public function scopePopular($query)
    {
        return $query->orderBy('sold_count', 'desc');
    }
}