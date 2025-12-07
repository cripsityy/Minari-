<?php

namespace App\Helpers;

class FormatHelper
{
    public static function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    
    public static function formatDate($date, $format = 'd F Y')
    {
        return \Carbon\Carbon::parse($date)->translatedFormat($format);
    }
    
    public static function getOrderStatusBadge($status)
    {
        $badges = [
            'pending' => 'badge-pending',
            'processing' => 'badge-shipped',
            'shipped' => 'badge-shipped',
            'delivered' => 'badge-delivered',
            'cancelled' => 'badge-cancelled'
        ];
        
        return $badges[$status] ?? 'badge-pending';
    }
    
    public static function getPaymentStatusBadge($status)
    {
        $badges = [
            'pending' => 'badge-pending',
            'paid' => 'badge-delivered',
            'failed' => 'badge-cancelled',
            'refunded' => 'badge-cancelled'
        ];
        
        return $badges[$status] ?? 'badge-pending';
    }
    
    public static function getProductStatusBadge($status)
    {
        $badges = [
            'available' => 'badge-active',
            'out_of_stock' => 'badge-cancelled',
            'pre_order' => 'badge-scheduled'
        ];
        
        return $badges[$status] ?? 'badge-active';
    }
    
    public static function generateOrderNumber()
    {
        $prefix = 'MIN';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        return $prefix . $date . $random;
    }
    
    public static function calculateDiscount($price, $discountPrice)
    {
        if (!$discountPrice) return 0;
        return round((($price - $discountPrice) / $price) * 100);
    }
}