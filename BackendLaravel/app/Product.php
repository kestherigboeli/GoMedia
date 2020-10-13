<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $guarded = [];
	/**
	 * Get the phone record associated with the user.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
