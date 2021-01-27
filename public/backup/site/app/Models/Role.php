<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    
	public function users()
	{
		return $this->belongsToMany(User::Class);
	}

}
