<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Product extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'merchant_code',
        'code',
        'name',
        'stock',
        'description',
        'status'
    ];
    
	protected $hidden = ['created_at','updated_at', 'deleted_at'];

    public function categories()
    {
		return $this->hasMany('App\Models\ProductCategory', 'product_code','code');
	}
    public function merchant()
    {
		return $this->belongsTo('App\Models\Merchant', 'code');
	}

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate(['table' => 'products','field' => 'code','length' => 8, 'prefix' => 'PR']);
        });
    }
}
