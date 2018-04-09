<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class List extends Authenticatable
{
    protected $fillable = ['name'];

    public function user()
    {
      return $this->belongsTo( User::class );
    }
}
