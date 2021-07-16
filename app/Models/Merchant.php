<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Merchant extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'code',
        'name',
        'description',
        'status'
    ];
    
	protected $hidden = ['created_at','updated_at', 'deleted_at'];

    public function user()
    {
		return $this->belongsTo('App\Models\User', 'merchant_id');
	}
    public function merchants()
    {
		return $this->hasMany('App\Models\Merchant', 'code');
	}

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate(['table' => 'merchants', 'field' => 'code', 'length' => 8, 'prefix' => 'MR']);
        });
    }
}
