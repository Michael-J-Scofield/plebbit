<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Vote;
use Illuminate\Support\Facades\Auth;
use App\subPlebbit;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Moderator;

class commentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name, $code, Request $request, Thread $thread, Vote $vote, subPlebbit $plebbit, Moderator $moderator)
    {
        $thread = $thread->where('code', $code)->first();
        $subPlebbit = $plebbit->where('name', $name)->first();
        $mod = false;

        if ( (!$subPlebbit) || (!$thread) ) {
            return view('threads.not_found');
        }
        if ($thread->post) {
            $thread->post = Markdown::convertToHtml($thread->post); // <p>foo</p>
        }
        $userVotes = false;
        if (Auth::check()) {
            $user = Auth::user();
            $userVotes = $vote->where('user_id', $user->id)->where('thread_id', $thread->id)->get();
            $mod = $moderator->isMod($user->id, $subPlebbit);
        }
        if ($request->segment(1) == 'amp') {
            return view('threads.amp_thread', array('thread' => $thread, 'subPlebbit' => $subPlebbit, 'userVotes' => $userVotes, 'mod' => $mod));
        } else {
            return view('threads.thread', array('thread' => $thread, 'subPlebbit' => $subPlebbit, 'userVotes' => $userVotes, 'mod' => $mod));
        }
    }
}
