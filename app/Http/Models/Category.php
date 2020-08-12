<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_ad'];
	protected $tables = 'categories';
	protected $hidden = ['created_ad', 'update_ad'];
}
