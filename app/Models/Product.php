<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_id',
        'original_price',
        'sale_price',
        'stock',
        'weight',
        'description',
        'slug', 
        'label'
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function reviews() 
    {
        return $this->hasMany(ProductReview::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                 $product->slug = self::generateSlug($product->product_name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('product_name')) {
                $product->slug = self::generateSlug($product->product_name);
            }
        });
    }

    private static function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = Product::where('slug', '=', $slug)
                        ->orWhere('slug', 'LIKE', $slug . '-%')
                        ->count();

        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }
}
