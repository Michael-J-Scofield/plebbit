<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Math;

class Vote extends Authenticatable
{
    protected $table = 'votes';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote', 'user_id', 'thread_id', 'post_id'
    ];


}
