<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductProperties extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'product_properties';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
