<?php

class Pas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pass';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
// 	protected $hidden = array('password', 'remember_token');

	public function setPasswordAttribute($value)
	{
		Log::info('PasモデルでpasswordをHashする');
		$this->attributes['password'] = Hash::make($value);
	}
}
