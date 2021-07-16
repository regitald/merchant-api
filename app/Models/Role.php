<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];
    
	protected $hidden = ['created_at','updated_at', 'deleted_at'];

    public function users()
    {
		return $this->hasMany('App\Models\User', 'role_id');
	}
}
