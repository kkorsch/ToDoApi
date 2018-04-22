<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use App\Http\Requests\StoreListRequest;
use App\Transformers\TaskListTransformer;

class TaskListController extends Controller
{
    public function index( Request $request )
    {
      $tasklists = $request->user()->tasklists;

      return fractal()->collection( $tasklists )->includeTasks()->transformWith( new TaskListTransformer )->toArray();
    }

    public function show( TaskList $list )
    {
      $this->authorize( 'owner', $list );

      return fractal()->item( $list )->includeTasks()->transformWith( new TaskListTransformer )->toArray();
    }

    public function store( StoreListRequest $request )
    {
      $taskList = new TaskList;
      $taskList->name = $request->name;
      $taskList->user()->associate( $request->user() );

      $taskList->save();

      return fractal()->item( $taskList )->transformWith( new TaskListTransformer )->toArray();
    }

    public function update( StoreListRequest $request, TaskList $list )
    {
      $this->authorize( 'owner', $list );

      $list->name = $request->name;

      $list->save();

      return fractal()->item( $list )->transformWith( new TaskListTransformer )->toArray();
    }

    public function destroy( TaskList $list )
    {
      $this->authorize( 'owner', $list );

      $list->delete();

      return response( null, 204 );
    }
}
