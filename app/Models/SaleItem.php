<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;
    
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price_at_sale'];
    
    // Relationship: Belongs to a sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    
    // Relationship: Belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}