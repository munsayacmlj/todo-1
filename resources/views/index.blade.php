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

	<style type="text/css">
		
		.comment-input{
			display: none;
		}

		.func-btns{
			font-size: 12px;
		}

		.cancel-btn{
			display: none;
		}

		.edit_delete_btns{

		}

	</style>
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
				<div class="panel-heading" style="height: 80px;">
					<strong>{{ $task->task }} by {{ $task->user->name }}</strong>
					@if($task->user->name == Auth::user()->name)
						<div style="float: right; padding-bottom: 1em;">
							<a href='{{ url("/edit/$task->id") }}' class="edit_delete_btns">
				      			{{-- <button class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button> --}}
				      			Edit
				      		</a>
				      		<a href='{{ url("/delete/$task->id") }}' class="edit_delete_btns">
				      			{{-- <button class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button> --}}
				      			Delete
				      		</a>
						</div>
					@endif
				</div>
				<div id="well_{{ $task->id }}" class="outer-well">
					<div style="padding-top: 1em; padding-right: 1em; padding-left: 1em;" id="comment_{{ $task->id }}">
						@foreach($task->comments->reverse() as $comment)
							<div class="well" id="comment_{{ $comment->id }}">
								<input id="i_{{ $comment->id }}" class="comment-input" type="text" name="comment" value="{{ $comment->content }}">
								<span id="p_{{ $comment->id }}">{{ $comment->content }}</span>
								<small id="s_{{ $comment->id }}">by {{ $comment->user->name }}
									updated on {{ $comment->updated_at->diffForHumans() }}</small>
								<br>
								
								@if($comment->user->name == Auth::user()->name)
									<a href='#' class="edit-comment func-btns" data-id="{{ $comment->id }}" id="b_{{ $comment->id }}">
										Edit
									</a>
									<a href="#" id="bc_{{ $comment->id }}" class="func-btns cancel-btn" data-id="{{ $comment->id }}">Cancel</a>
									<a href="#" class="delete-comment func-btns"
										id="bd_{{ $comment->id }}" data-id="{{ $comment->id }}">
										Delete
									</a>
								@endif
							</div>
						@endforeach
					</div>
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
					$('#well_'+taskId).load(' #comment_'+taskId);
					// $("#well_"+taskId).load(' .comment-box');
					// $('#well_'+taskId).load(' #well_'+taskId);
					$('#comment_'+taskId).prepend('<div class="well"><p>' + comment  + '<small> by ' + user +
					' on ' + data.time + '</small>' +'</p></div>');
					$('#'+taskId).val("");
				}
			});
		});

		$(".outer-well").on('click', '.delete-comment', function() {
					var commentId = $(this).data('id');
					$.ajax({
						url: '/comment/delete/'+commentId,
						type: 'GET',
						data: {
							_token : "{{ csrf_token() }}"
						},
						success:function(data){
							$("#comment_"+commentId).remove();
						}
					});
					return false;
		});
	
		$('.outer-well').on('click', '.edit-comment', function() {
			var pId = $(this).data('id');
			var p = $('#p_'+pId).html();
			$("#p_"+pId).hide();
			$("#s_"+pId).hide();
			// $('#i_'+pId).val(p);
			$("#i_"+pId).show();
			$('#bc_'+pId).show();
			$('#bd_'+pId).hide();
			if ($(this).html() == 'Save') {
				var input = $('#i_'+pId).val();
				$.ajax({
					url: '/comment/edit/'+pId,
					type: 'POST',
					data: {
						_token : "{{ csrf_token() }}",
						input : input
					},
					success:function(data) {
						// $('#well_'+taskId).load(' #well_'+taskId);
						$("#p_"+pId).html(input);
						$('#p_'+pId).show();
						$('#s_'+pId).show();
						$("#i_"+pId).hide();
						$('#bd_'+pId).show();
						$('#bc_'+pId).hide();
						$("#b_"+pId).html('Edit');
					}
				});
				return false;				
			}
			$(this).html('Save');
		});

		// $('.edit-comment').click(function() {
		// });
		$('.outer-well').on('click', '.cancel-btn', function() {
					var pId = $(this).data('id');
					$('#p_'+pId).show();
					$('#s_'+pId).show();
					$("#i_"+pId).hide();
					$("#b_"+pId).html('Edit');
					$('#bd_'+pId).show();
					$('#bc_'+pId).hide();
		});
		// $('.cancel-btn').click(function() {
		// });
	</script>
</body>
</html>