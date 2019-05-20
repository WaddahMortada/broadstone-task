<?php

namespace App;

use App\Shift;
use App\Worker;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
	/** Approved status */
	const STATUS_APPROVED = 'approved';

	/** Decline status */
	const STATUS_DECLINED = 'declined';

	/** Pending status */
	const STATUS_PENDING = 'pending';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'worker_id', 'shift_id', 'status'
	];

	/**
	 * Shift relationship with Application
	 */
	public function shift()
	{
		return $this->belongsTo(Shift::class);
	}

	/**
	 * Worker relationship with Application
	 */
	public function worker()
	{
		return $this->belongsTo(Worker::class);
	}

	/**
	 * Return application Id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Return Shift Id
	 *
	 * @return string
	 */
	public function getShiftId()
	{
		return $this->shift_id;
	}

	/**
	 * Return application's status
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Return Worker Id
	 *
	 * @return string
	 */
	public function getWorkerId()
	{
		return $this->worker_id;
	}

	/**
	 * Set Shift Id
	 *
	 * @param string $shiftId
	 *
	 * @return Application
	 */
	public function setShiftId($shiftId)
	{
		$this->shift_id = $shiftId;

		return $this;
	}

	/**
	 * Set Worker Id
	 *
	 * @param string $workerId
	 *
	 * @return Application
	 */
	public function setWorkerId($workerId)
	{
		$this->worker_id = $workerId;

		return $this;
	}

	/**
	 * Set application's status
	 *
	 * @param string $status
	 *
	 * @return Application
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setStatus($status)
	{
		switch ($status) {
			case self::STATUS_PENDING:
			case self::STATUS_APPROVED:
			case self::STATUS_DECLINED:
				$this->status = $status;
				break;

			default:
				throw new \InvalidArgumentException(
					'Application\'s status ('.$status.') is not supported!'
				);
				break;
		}

		return $this;
	}
}
