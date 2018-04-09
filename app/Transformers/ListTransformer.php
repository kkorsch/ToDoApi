<?php

namespace App\Transformers;

use App\Models\List;
use League\Fractal\TransformerAbstract;

class ListTransformer extends TransformerAbstract
{
  public function transform( List $list )
  {
    return [
      'id' => $list->id,
      'name' => $list->name,
      'created_at' => $list->created_at->toDateString(),
      'created_at_humans' => $list->created_at->diffForHumans(),
    ];
  }
}
