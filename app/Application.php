<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'worker_id', 'shift_id', 'status'
	];
}
