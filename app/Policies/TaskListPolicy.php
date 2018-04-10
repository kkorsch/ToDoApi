<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaskList;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskListPolicy
{
    use HandlesAuthorization;

    public function update( User $user, TaskList $list )
    {
      return $user->ownsList( $list );
    }

    public function destroy( User $user, TaskList $list )
    {
      return $user->ownsList( $list );
    }
}
