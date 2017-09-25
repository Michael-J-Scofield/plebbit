<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Math;

class Post extends Authenticatable
{
    protected $table = 'posts';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_display_name', 'thread_id', 'parent_id', 'upvotes', 'downvotes', 'score', 'comment', 'timestamp'
    ];

    public function postsbyUser($id, $sort, $skip, $amount)
    {
        if ($sort == 'popular') {
            return $this->where('user_id', $id)->orderBy('score', 'DESC')->orderBy('created_at', 'DESC')->skip($skip)->take($amount)->get();
        }
        else if ($sort == 'top') {
            return $this->where('user_id', $id)->orderBy('score', 'DESC')->skip($skip)->take($amount)->get();
        }
        else if ($sort == 'new') {
            return $this->where('user_id', $id)->orderBy('created_at', 'DESC')->skip($skip)->take($amount)->get();
        }
        else {
            return false;
        }
    }
}
