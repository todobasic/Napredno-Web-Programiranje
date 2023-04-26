<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentUser = DB::table('users')->where('email', Auth::user()->email)->first();
        App::setlocale($currentUser->locale);

        $allUsers = DB::table('users')->get();
        $dataUsers = array();
        foreach ($allUsers as $user) {
            array_push($dataUsers, $user);
        }

        $allTasks = DB::table('tasks')->get();
        $dataTasks = array();
        foreach ($allTasks as $task) {
            array_push($dataTasks, $task);
        }
        if (Auth::user()->role == '/') {
            return view('role_selection');
        } else {
            return view('home', ['dataUsers' => $dataUsers, 'dataTasks' => $dataTasks]);
        }
    }

    public function changeEn()
    {
        $userId = Request::input('user_id');

        DB::table('users')->where('id', $userId)->update(['locale' => 'en']);
        return Redirect::to('/home');
    }

    public function changeHr()
    {
        $userId = Request::input('user_id');

        DB::table('users')->where('id', $userId)->update(['locale' => 'hr']);
        return Redirect::to('/home');
    }
}
