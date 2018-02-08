<!DOCTYPE html>
<html>
<head>
	{{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css"> --}}
	{{-- <meta name="csrf-token"> --}}
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<title>To do List</title>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ url('/home') }}">Task List</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
     @guest
    	<li>
    		<a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
    	</li>
    	<li>
    		<a href="#"><span class="glyphicon glyphicon-user"></span> Login</a>
    	</li>
     @else
    	<li><a href="#">Hello, {{ Auth::user()->name }}</a></li>
     @endguest
    </ul>
  </div>
</nav>
	<div class="container">
		<div class="row">
		
		<div class="panel panel-default" style="width: 50%; margin: 1em auto;">
		  <div class="panel-heading">New Task</div>
		  <div class="panel-body">
		  	@include('error')
		  	@if(Session::has('status'))
		  		<div class="alert alert-success" style="width: 50%; margin: 1em auto;">
		  			<strong>Success!</strong><span> {{Session::get('status')}}</span>
		  		</div>
		  	@endif
		  	<form action="/task" method="POST">
			  	<div class="form-group" style="width: 50%; margin: 0 auto;">
			  		{{csrf_field()}}
			  		<div class="form-inline">
				  		<label>Task</label>
				  		<input type="text" name="task" class="form-control" style="width: 80%;">
			  		</div>
			  		<button type="submit" name="submit" value="Add Task" class="btn btn-default" style="margin-left: 2.5em; margin-top: 1em;">
			  		<i class="fas fa-plus"></i> Add Task</button>
			  	</div>
		  	</form>
		  </div>
		</div>

		{{-- <div class="panel panel-default" style="width: 50%; margin: 1em auto;">
		  <div class="panel-heading">Current Tasks</div>
		  <div class="panel-body">

		  	<table class="table table-striped">
			    <thead>
			      <tr>
			        <th colspan="3">Task</th>
			      </tr>
			    </thead>
			    <tbody>
			    	@foreach ($tasks as $task)
				      <tr>
					      	<td> 
					      			{{ $task->task }} by {{$task->user->name}}
					      	</td>
					      	<td>
					      		<a href='{{ url("/edit/$task->id") }}'>
					      			<button class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
					      		</a>
					      	</td>
					      	<td>
					      		<a href='{{ url("/delete/$task->id") }}'><button class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button></a>
					      	</td>
				      </tr>
			      @endforeach
			    </tbody>
			 </table>
		  </div>
		</div> --}}

		@foreach ($tasks as $task)
			<div class="panel panel-default" style="width: 50%; margin: 1em auto;">
				<div class="panel-heading">
					{{ $task->task }} by {{ $task->user->name }}
				</div>
				<div style="padding-top: 1em; padding-left: 1em;" id="task_{{ $task->id }}">
						@foreach($task->comments as $comment)
							<p>{{ $comment->content }} <small>by {{ $comment->user->name }}
								on {{ $comment->created_at->diffForHumans() }}</small></p>
						@endforeach
				</div>
				<div class="panel-body">
					{{-- <form action='{{ url("/comment/$task->id") }}' method="POST"> --}}
						{{-- {{ csrf_field() }} --}}
						<div class="form-group">
							<label>Comment</label>
							<input type="text" name="comment" class="form-control" id="{{ $task->id }}">
						</div>
						<button class="btn btn-success submit-comment" data-id="{{ $task->id }}">Submit</button>
					{{-- </form> --}}
				</div>
			</div>
		@endforeach
		</div> {{-- row --}}
	</div>{{-- container --}}

	<script type="text/javascript">
		$('.submit-comment').click(function() {
			var taskId = $(this).data('id');
			var comment = $('#'+taskId).val();
			var user = "{{ Auth::user()->name }}";
			$.ajax({
				url: '/comment/'+taskId,
				type: 'POST',
				data: {
					_token : "{{ csrf_token() }}",
					comment : comment
				},
				success:function(data) {
					$('#task_'+taskId).append('<p>' + comment  + '<small> by ' + user +
					' on ' + data.time + '</small>' +'</p>');
					$('#'+taskId).val("");
				}
			});
		});
	</script>
</body>
</html>