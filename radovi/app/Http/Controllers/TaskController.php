<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function openMenu(){
        $loggedUser = DB::table('users')->where('email', Auth::user()->email)->first();
        App::setlocale($loggedUser->locale);
        return view('add_task');
    }

    public function addWork(){
        $naziv_rada = Request::input('naziv_rada');
        $naziv_rada_eng = Request::input('naziv_rada_eng');
        $zadatak_rada = Request::input('zadatak_rada');
        $tip_stud = Request::input('tip_stud');
        $profesor = Request::input('profesor');
        DB::table('tasks')->insert(
            [
                'name' => $naziv_rada,
                'name_en' => $naziv_rada_eng,
                'task_goal' => $zadatak_rada,
                'study_type' => $tip_stud,
                'profesor' => $profesor
            ]
        );

        return redirect('/home');
    }

    public function acceptStudent(){
        $task_id = Request::input('taskId');
        $tasksData = DB::table('tasks')->get()->where('id', $task_id);

        foreach ($tasksData as $task) {
            $students = array();
            $appliedStudents = array();
            array_push($appliedStudents,$task->students);
            $appliedStudentsParts = explode(',', $appliedStudents[0]);

            foreach($appliedStudentsParts as $part){
                array_push($students, $part);
            }
        }

        return view('task_details', ['tasksData' => $tasksData, 'students' => $students]);
    }
}
