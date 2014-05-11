<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	/**
	 * Primary Key
	 */
	protected $primaryKey = 'id';
	
	/**
	 * Fillable columns
	 */
	protected $fillable = [
		'id',
		'name', 
		'email'
	];
	
	/**
	 * Guarded columns
	 */
	protected $guarded = [
		'password'
	];
	
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
	protected $hidden = [
		'password'
	];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	/*
	** return string: the user's full name
	*/
	public function getFullName() {
		return $this->name;
	}
	
	/*
	** Check for the Administrator role
	** return bool
	*/
	public function isAdministrator() {
		return $this->hasRole('Administrator');
	}

	/* 
	** Checks if a user has a particular role
	** string $role: The name of the role
	** return bool 
	*/
	public function hasRole($role) {
		$roles = $this->roles()->where('name', $role)->count();

		return ($roles > 0);
	}

	/*
	** Convert the tinyint to a true boolean for consistency
	** return bool
	*/
	public function isEnabled() {
		return ($this->enabled == 1);
	}
	
	/**
	 * Role relationship
	 */
	public function roles() {
		return $this->belongsToMany('Roles', 'role_id');
	}
	
}
