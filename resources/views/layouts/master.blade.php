<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

	<script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>
</head>

<body class="text-gray-800" style="background-color: #edf2f7">
	
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

	<div class="container mx-auto">
		@yield('app')
	</div>

	@if(!request()->is('login*') && !request()->is('password*'))
		@include('kustomer::kustomer')
	@endif
</body>

<script type="text/javascript" src="{{ mix('js/all.js') }}"></script>
<script type="text/javascript">
	flatpickr('.datepicker', {
		locale: 'es',
	    altInput: true,
	    altFormat: "d/m/Y",
	    dateFormat: "Y-m-d",
	});

	$('form button').click(function(e) {
		$(this).append('<i class="fas fa-circle-notch fa-spin ml-2"></i>')
		return true
	})
	$('form').submit(function(e) {
		var button = $($(this).find('button')[0])
		button.attr("disabled", true);
		return true
	})

	if($('table').length > 0) {
		new Tablesort($('table')[0], {descending: true});
		$('th').each(function () {
			$(this).append('<i class="fas fa-sort hover:cursor-pointer ml-1"></i>');
		});
	}
</script>

@stack('js')

</html>