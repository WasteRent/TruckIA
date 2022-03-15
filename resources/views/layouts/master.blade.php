<!DOCTYPE html>
<html>
<head>
	<title>truck-i</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	@bukStyles(true)
</head>

<body>
	@if(isset($banner) && $banner)
		<div class="relative bg-red-200">
		  <div class="max-w-screen-xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
		    <div class="pr-16 sm:text-center sm:px-16">
		      <p class="font-medium text-white">
		        <span class="text-red-800">
		        	{{ $banner_content }}
		        </span>
		      </p>
		    </div>
		  </div>
		</div>
	@endif	

	<div id="app">
		@include('layouts.content')
	</div>

</body>


<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

@bukScripts(true)

<script type="text/javascript">
	$('form button').click(function(e) {
		$(this).append('<i class="fas fa-circle-notch fa-spin ml-2"></i>')
		return true
	})
	$('form').submit(function(e) {
		var button = $($(this).find('button')[0])
		button.attr("disabled", true);
		return true
	})
	
	var msg = '{{Session::get('alert')}}';
	var exist = '{{Session::has('alert')}}';
	if(exist){
		alert(msg);
	}
</script>

@stack('js')

</html>