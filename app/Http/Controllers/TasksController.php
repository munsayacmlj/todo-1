<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Validator;
class TasksController extends Controller {

	public function saveTask(Request $request) {

		$validator = $request->validate([
			'task' => array('required','regex:/(^(task+)\s(\d+)?$)/u')
		]);

		$new_task = new Task();
		$new_task->task = $request->task;
		$new_task->save();

		$request->session()->flash('status', 'Task was successful!');
		return redirect('/');
	}

	public function showTasks() {
		$tasks = Task::all();
		return view('index', compact('tasks'));
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
}
