<?php

namespace App\Http\Controllers;

use App\Application;
use App\Shift;
use App\Worker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class WorkerApplicationsController extends Controller
{
	/**
	 * Get all worker's applications
	 *
	 * @param Request $request
	 * @param string  $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function viewApplications(Request $request, $id)
	{
		/** Find worker by id */
		$worker = Worker::findOrFail($id);

		if (null !== $status = $request->get('status')) {
			/** Get applications by status */
			$applications = $worker->application->where('status', $status);
		} else{
			/** Find all worker's applications */
			$applications = $worker->application;
		}

		/**
		 * Add/include application's shift object
		 */
		if ($request->get('shift') === 'include') {
			foreach ($applications as $application) {
				$application->shift;
			}
		}

		return response()->json($applications, 200);
	}

	/**
	 * Approve or decline a selection of applications for a worker
	 *
	 * @param Request $request
	 * @param string  $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, $id)
	{
		/** Get request content and convert it to array */
		$content = json_decode($request->getContent(), true);

		if (!is_array($content)) {
			abort(400, 'bad request');
		}

		/** Find worker by Id */
		$worker = Worker::findOrFail($id);

		/** Find worker's applications */
		$applications = $worker->application;

		/**
		 * Iterate over submitted applications from a request and process them
		 */
		foreach ($content as $app) {
			/** Validate the submitted application field */
			$this->validateApplicationArray($app);

			/**
			 * Find Application object
			 * (Make sure the submitted application belong to the worker)
			 */
			$application = $applications->find($app['id']);

			if (!($application instanceof Application)) {
				throw new ModelNotFoundException(
					'Error, could not find application (id:'.$app['id'].
					') for Worker (id:'.$id.')'
				);
			}

			/** Find application's Shift */
			$shift = $application->shift;

			/** Validate an application request agenst a set of conditions */
			$this->validateApplicationRequest($application, $shift, $app);

			/** Update application's status to approve or decline */
			$application->setStatus($app['status']);

			$application->save();

			/** On application approval update shift's application */
			if ($app['status'] === Application::STATUS_APPROVED) {
				$shift->setApplicationId($application->getId());

				$shift->save();
			}
		}

		return response()->json('The request has succeeded', 200);
	}

	/**
	 * Validate the submitted application field
	 * (Make sure all the required fields are set and correct)
	 *
	 * @param  array  $application
	 *
	 * @throws HttpException
	 */
	protected function validateApplicationArray(array $application)
	{
		/** Expected application status */
		$status = [
			Application::STATUS_APPROVED,
			Application::STATUS_DECLINED
		];

		/** Set a customised error message */
		$messages = [
			'in' => 'The :attribute must be one of the following types: :values'
		];

		/** Set validation rules */
		$rules = [
			'id' => ['required', 'integer', 'numeric'],
			'status' => ['required', 'string', Rule::in($status)]
		];

		/** Validate */
		$validator = Validator::make($application, $rules, $messages);

		/** Report error if found */
		if (!$validator->passes()) {
			abort(
				400,
				$validator->errors()->first()
			);
		}
	}

	/**
	 * Validate an application request agenst a set of conditions and
	 * return an HTTP status codes and error message on failer
	 *
	 * Make sure the submitted request is valid.
	 * ex: make sure that shift is not already taken by another application
	 *
	 * @param  Application $application
	 * @param  Shift       $shift
	 * @param  array       $app
	 *
	 * @throws HttpException
	 */
	protected function validateApplicationRequest(
		Application $application,
		Shift $shift,
		array $app
	) {
		/**
		 * Is application already processed?
		 *
		 * Don't process application unless it is in pending status
		 */
		if ($application->getStatus() !== Application::STATUS_PENDING) {
			abort(
				400,
				'Application (id: '.$application->getId().') is already processed!'
			);
		}

		/**
		 * Is shift is alredy taken by another application?
		 *
		 * Don't overwrite shift's application (prevent double booking)
		 */
		if ($app['status'] === Application::STATUS_APPROVED
			&& $shift->getApplicationId() != null
		) {
			abort(
				400,
				'Shift (id:'.$shift->getId().') is already taken'
			);
		}

		/**
		 * Is the declined application the last/only application for a shift?
		 *
		 * Don't accept a declined application if it's the last/only one for a shift
		 */
		if ($app['status'] === Application::STATUS_DECLINED
			&& $shift->getApplicationId() == null
		) {
			$shiftId = $shift->getId();

			$count = Application::where('shift_id', $shiftId)
				->where('status', Application::STATUS_PENDING)
				->count();

			if ($count === 1) {
				abort(
					400,
					'Cannot decline application (id:'.$application->getId().
					') because it is the last/only application for shift (id:'.$shiftId.')'
				);
			}
		}
	}
}
