<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\TaskListTransformer;

class TaskListController extends Controller
{
    public function index( Request $request )
    {
      $tasklists = $request->user()->tasklists;

      return fractal()->collection( $tasklists )->transformWith( new TaskListTransformer )->toArray();
    }
}
