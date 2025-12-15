<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'applicable_categories',
        'applicable_products'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'applicable_categories' => 'array',
        'applicable_products' => 'array'
    ];

    public function getIsValidAttribute()
    {
        return $this->is_active && 
               now()->between($this->start_date, $this->end_date) &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function getFormattedValueAttribute()
    {
        return $this->type === 'percentage' 
            ? $this->value . '%' 
            : 'Rp ' . number_format($this->value, 0, ',', '.');
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        $now = now();

        if ($now->lt($this->start_date)) {
            return 'Scheduled';
        }

        if ($now->gt($this->end_date)) {
            return 'Expired';
        }

        return 'Active';
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'Active' => 'badge-active',
            'Scheduled' => 'badge-pending',
            'Expired' => 'badge-inactive',
            'Inactive' => 'badge-inactive',
            default => 'badge-secondary',
        };
    }
    
    public function calculateDiscount($amount)
    {
        if (!$this->is_valid || ($this->min_purchase && $amount < $this->min_purchase)) {
            return 0;
        }

        return match($this->type) {
            'percentage' => $amount * ($this->value / 100),
            'fixed' => min($this->value, $amount),
            'free_shipping' => 0,
            default => 0
        };
    }
}