<?php

namespace App\Transformers;

use App\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
  public function transform( Task $task )
  {
    $remind_at = $task->remind_at ? $task->remind_at->toDateString() : $task->remind_at;
    
    return [
      'id' => $task->id,
      'body' => $task->body,
      'remind_at' => $remind_at,
      'created_at' => $task->created_at->toDateString(),
      'created_at_humans' => $task->created_at->diffForHumans(),
    ];
  }
}
