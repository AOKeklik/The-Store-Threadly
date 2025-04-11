<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function expire_date($format = 'd M, Y')
    {
        if (is_null($this->expire_date)) 
        return null;

        try {
            return \Carbon\Carbon::parse($this->expire_date)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function discount()
    {
        if ($this->discount_type === 'percent') {
            if ($this->discount == floor($this->discount))
                $formattedDiscount = (int)$this->discount;
            else
                $formattedDiscount = $this->discount;
    
            return $formattedDiscount . '%';
        }
        
        $currencyIcon = setting('site_currency_icon'); 
        $currencyPosition = setting('site_currency_icon_position');
    
        if ($currencyPosition === 'right')
            return $currencyIcon . ' ' . $this->discount;
    
        return $this->discount . ' ' . $currencyIcon;
    }

    protected static function booted()
    {
        static::saving(function ($coupon) {
            if (!empty($coupon->code)) {
                $coupon->code = strtoupper($coupon->code);
            }

            if (empty($coupon->expire_date)) {
                $coupon->expire_date = now()->addDays(9);
            }

            if (empty($coupon->quantity)) {
                $coupon->quantity = 99;
            }

            if (empty($coupon->min_purchase_amount)) {
                $coupon->min_purchase_amount = 0;
            }
        });
    }
}
