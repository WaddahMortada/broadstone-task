<?php

namespace App\Http\Controllers;

use App\Worker;
use App\Http\Resources\WorkerCollection;
use App\Http\Resources\Worker as WorkerResource;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
	/**
	 * Return a collection of workers
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$workers = new WorkerCollection(
			Worker::paginate()
		);

		return response()->json($workers, 200);
	}
}
