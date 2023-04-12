<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(mixed $product_id)
 */
class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order');
    }

    protected $appends = ['image_path', 'profit_percent'];

    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/' . $this->image);
    }// end of image pth

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->buy_price; // 100 - 80 = 20
        $profit_percent = ($profit * 100) / $this->buy_price;

        return number_format($profit_percent, 2);
    }
}






