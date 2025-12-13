<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'birth_date',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // Relasi dengan Cart
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi dengan Wishlist
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relasi dengan Order
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Relasi dengan Review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Atribut tambahan untuk cart count
    public function getCartCountAttribute()
    {
        return $this->carts()->count();
    }

    // Atribut tambahan untuk wishlist count
    public function getWishlistCountAttribute()
    {
        return $this->wishlists()->count();
    }

    // Relasi dengan UserAddress
    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}