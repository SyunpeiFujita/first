<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * Pas側で行うのでこっちではやらない
	 */
// 	public function setPasswordAttribute($value)
// 	{
// 		Log::info('パスワードHashする');
// 		$this->attributes['password'] = Hash::make($value);
// 	}
// 	public function setUsernameAttribute($value)
// 	{
// 		Log::info('usernameをHashする');
// 		$this->attributes['username'] = Hash::make($value);
// 	}
}
