<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'product_code',
        'category_code'
    ];
    
	protected $hidden = ['created_at','updated_at'];

    public function product()
    {
		return $this->belongsTo('App\Models\Product', 'code','product_code');
	}
    public function category()
    {
		return $this->belongsTo('App\Models\Category', 'code','category_code');
	}
}
