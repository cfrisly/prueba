<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $tables = 'products';
	protected $hidden = ['created_at', 'update_at'];
}