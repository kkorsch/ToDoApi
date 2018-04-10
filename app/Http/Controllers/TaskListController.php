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

      return fractal()->collection( $tasklists )->transformWith( new TaskListTransformer )->toArray();
    }

    public function store( StoreListRequest $request )
    {
      $taskList = new TaskList;
      $taskList->name = $request->name;
      $taskList->user()->associate( $request->user() );

      $taskList->save();

      return fractal()->item( $taskList )->transformWith( new TaskListTransformer )->toArray();
    }
}
