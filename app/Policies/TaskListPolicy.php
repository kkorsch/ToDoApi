<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaskList;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskListPolicy
{
    use HandlesAuthorization;

    public function owner( User $user, TaskList $list )
    {
      return $user->ownsList( $list );
    }
}
