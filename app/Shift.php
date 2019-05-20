<?php

namespace App;

use App\Application;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'from', 'to', 'application_id'
	];

	/**
	 * Application relationship with Shift
	 */
	public function application()
	{
		return $this->hasOne(Application::class);
	}

	/**
	 * Return shift Id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Return Application Id
	 *
	 * @return string|null
	 */
	public function getApplicationId()
	{
		return $this->application_id;
	}

	/**
	 * Return From date time (start form date time)
	 *
	 * @return string datetime (Y-m-d H:i:s)
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Return To date time (end to date time)
	 *
	 * @return string datetime (Y-m-d H:i:s)
	 */
	public function getTo()
	{
		return $this->from;
	}

	/**
	 * Set Application Id
	 *
	 * @param string $applicationId
	 *
	 * @return Shift
	 */
	public function setApplicationId($applicationId)
	{
		$this->application_id = $applicationId;

		return $this;
	}

	/**
	 * Set from date time
	 *
	 * @param string $from datetime (Y-m-d H:i:s)
	 *
	 * @return Shift
	 */
	public function setFrom($from)
	{
		$this->from = $from;

		return $this;
	}

	/**
	 * Set to date time
	 *
	 * @param string $to datetime (Y-m-d H:i:s)
	 *
	 * @return Shift
	 */
	public function setTo($to)
	{
		$this->to = $to;

		return $this;
	}
}
