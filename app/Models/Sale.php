<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = ['total_amount'];
    
    // Relationship: A sale has many sale items
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}