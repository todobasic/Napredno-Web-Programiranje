<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setUserRole()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $userRole = Request::input('role');
            DB::table('users')->where('id', $userId)->update(['role' => $userRole]);

            return view('welcome');
        }
    }

    public function editUserRole()
    {
        $userId = Request::input('user_id');
        $role = Request::input('role');
        DB::table('users')->where('id', $userId)->update(['role' => $role]);

        return Redirect::to('/home');
    }

    public function registerWork()
    {
        $user = Request::input('user');
        $taskId = Request::input('taskId');
        $studentslist = DB::table('tasks')->get()->where('id', $taskId)->pluck('students');

        $studentslistString = (string)$studentslist[0];
        if (Auth::user()->role == 'Student' && strpos($studentslistString, $user) !== true) {
            if ($studentslistString == "")
                $studentslistString = $user;
            else {
                $studentslistString = $studentslistString . ", " . $user;
            }
        }

        DB::table('tasks')->where('id', $taskId)->update(['students' => $studentslistString]);

        return Redirect::to('/home');
    }

    public function confirmStudent()
    {
        $student = Request::input('student');
        $taskId = Request::input('task_id');

        DB::table('tasks')->where('id', $taskId)->update(['choosen_student' => $student]);

        return Redirect::to('/home');
    }
}
