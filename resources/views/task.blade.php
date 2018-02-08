<!DOCTYPE html>
<html>
<head>
	{{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css"> --}}
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<title>To do List</title>
</head>
<body>
	<div class="container">
		<div class="row">
		<div class="form-group" style="width: 40%;">
			<h4>{{ $task->task }}</h4>
			<form method="POST">
				{{csrf_field()}}
				<div class="form-inline">
					<label>Comment</label>
					{{-- <input type="text" name="comment" class="form-control"> --}}
					<textarea name="comment" rows="4" cols="50"></textarea>
				</div>
				<input type="submit" name="submit" value="Submit" class="btn btn-success" style="margin-top: 1em;">
			</form>
		</div>
		
		</div> {{-- row --}}
	</div>{{-- container --}}



</body>
</html>