<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Transformers\TaskTransformer;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function store( StoreTaskRequest $request, TaskList $list )
    {
      $this->authorize( 'owner', $list );

      $task = new Task;
      $task->body = $request->body;
      $task->remind_at = $request->get( 'remind_at', null );

      $list->tasks()->save( $task );

      return fractal()->item( $task )->transformWith( new TaskTransformer )->toArray();
    }

    public function update( UpdateTaskRequest $request, TaskList $list, Task $task )
    {
      if ( $list->id !== $task->taskList->id ) {
        return response( null, 404 );
      }

      $this->authorize( 'owner', $list );

      $task->body = $request->get( 'body', $task->body );
      $task->remind_at = $request->get( 'remind_at', $task->remind_at );

      $task->save();

      return fractal()->item( $task )->transformWith( new TaskTransformer )->toArray();
    }

    public function destroy( TaskList $list, Task $task )
    {
      if ( $list->id !== $task->taskList->id ) {
        return response( null, 404 );
      }

      $this->authorize( 'owner', $list );

      $task->delete();

      return response( null, 204 );
    }
}
