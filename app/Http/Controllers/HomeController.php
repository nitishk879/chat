<?php

namespace App\Http\Controllers;

use App\Events\GroupCreated;
use App\Events\MessageSent;
use App\Group;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = auth()->user()->groups;

        $users = User::where('id', '<>', auth()->user()->id)->get();
        $user = auth()->user();

//        return view('home', ['groups' => $groups, 'users' => $users, 'user' => $user]);

        return view('chat.index', compact('groups', 'users', 'user'));
    }
    public function coming()
    {
        return Message::with('user')->get();
    }
    public function send(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function store(){
        $group = Group::create(['name' => request('name')]);

        $users = collect(request('users'));
        $users->push(auth()->user()->id);

        $group->users()->attach($users);
        broadcast(new GroupCreated($group))->toOthers();
        return $group;
    }
}
