<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Validator;
use Auth;

class TasksController extends Controller {

	public function __construct(){
        $this->middleware('auth');
    }
 
	public function saveTask(Request $request) {
		$validator = $request->validate([
			'task' => array('required','regex:/(^([a-zA-Z]+)\s(\d+)?$)/u')
		]);

		$new_task = new Task();
		$new_task->task = $request->task;
		$new_task->user_id = Auth::user()->id;
		$new_task->save();

		$request->session()->flash('status', 'Task was created successfully!');
		return redirect('/');
	}

	public function showTasks() {
		// $tasks = Auth::user()->tasks;
		$tasks = Task::all();
		return view('index', compact('tasks'));
	}

	public function showAllTasks() {

	}

	public function delete($id) {
		$task = Task::findOrFail($id)->delete();
		return redirect('/');
	}

	public function edit($id) {
		$task = Task::find($id);
		return view('edit', compact('task'));
	}

	public function update(Request $request, $id) {
		$task = Task::find($id);
		$task->task = $request->task;
		$task->save();
		return redirect('/');
	}

	public function showTask($id) {
		$task = Task::find($id);
		return view('task', compact('task'));
	}
}
