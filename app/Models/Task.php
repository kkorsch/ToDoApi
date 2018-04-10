<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
      'body', 'remind_at',
    ];

    public function taskList()
    {
      return $this->belongsTo( TaskList::class );
    }
}
