<?php

namespace App;

use App\Application;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Worker extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Application relationship with Worker
	 */
	public function application()
	{
		return $this->hasMany(Application::class);
	}

	/**
	 * Return Id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Return name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Return email address
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Return email verified at
	 *
	 * @return string|null datetime (Y-m-d H:i:s)
	 */
	public function getEmailVerifiedAt()
	{
		return $this->email_verified_at;
	}

	/**
	 * Return password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Return phone
	 *
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Worker
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Set email address
	 *
	 * @param string $email
	 *
	 * @return Worker
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Set email verified at
	 *
	 * @param string $emailVerifiedAt datetime (Y-m-d H:i:s)
	 *
	 * @return Worker
	 */
	public function setEmailVerifiedAt($emailVerifiedAt)
	{
		$this->email_verified_at = $emailVerifiedAt;

		return $this;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return Worker
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Set phone
	 *
	 * @param string $phone
	 *
	 * @return Worker
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;

		return $this;
	}
}
