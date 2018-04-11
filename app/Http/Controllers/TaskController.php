<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Transformers\TaskTransformer;
use App\Http\Requests\StoreTaskReqeust;

class TaskController extends Controller
{
    public function store( StoreTaskReqeust $request, TaskList $list )
    {
      $this->authorize( 'owner', $list );

      $task = new Task;
      $task->body = $request->body;
      $task->remind_at = $request->get( 'remind_at', null );

      $list->tasks()->save( $task );

      return fractal()->item( $task )->transformWith( new TaskTransformer )->toArray();
    }
}
