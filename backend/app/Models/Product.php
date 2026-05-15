<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'title','slug','description','image','images','price','original_price',
        'discount','rating','sold','stock','shipping','free_shipping','badge','category_id','is_active',
        'brand','custom_label','smart_bar','colors','attributes','size_guide','warranty',
    ];

    protected $casts = [
        'images'     => 'array',
        'colors'     => 'array',
        'attributes' => 'array',
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating'         => 'decimal:2',
        'free_shipping'  => 'boolean',
        'is_active'      => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
