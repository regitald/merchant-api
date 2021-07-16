<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Category extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'merchant_code',
        'code',
        'name',
        'description',
        'status'
    ];
    
	protected $hidden = ['created_at','updated_at', 'deleted_at'];

    public function product()
    {
		return $this->belongsTo('App\Models\ProductCategory', 'category_code','code');
	}

    public function merchant()
    {
		return $this->belongsTo('App\Models\Merchant', 'code', 'merchant_code');
	}
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate(['table' => 'categories', 'field' => 'code', 'length' => 8, 'prefix' => 'CT']);
        });
    }
}
