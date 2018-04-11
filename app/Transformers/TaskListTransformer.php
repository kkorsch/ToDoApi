<?php

namespace App\Transformers;

use App\Models\TaskList;
use League\Fractal\TransformerAbstract;

class TaskListTransformer extends TransformerAbstract
{
  protected $availableIncludes = [ 'tasks' ];

  public function transform( TaskList $list )
  {
    return [
      'id' => $list->id,
      'name' => $list->name,
      'created_at' => $list->created_at->toDateString(),
      'created_at_humans' => $list->created_at->diffForHumans(),
    ];
  }

  public function includeTasks( TaskList $list )
  {
    return $this->collection( $list->tasks, new TaskTransformer );
  }
}
