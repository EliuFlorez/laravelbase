<?php

class Role extends Eloquent {
	
	/**
	 * Primary Key
	 */
	protected $primaryKey = 'id';
	
	/**
	 * Fillable columns
	 */
	protected $fillable = [
		'id',
		'role'
	];
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_roles';
	
	/**
	 * User relationship
	 */
	public function users() {
		return $this->belongsToMany('User', 'user_id');
	}

}
