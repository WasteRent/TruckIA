@php
	$enlaces[] = [
		'name' => 'Dashboard',  
		'icon' => '<i class="fas fa-home mr-2 w-4"></i>', 
		'link' => route('admin.home'), 
		'active' => request()->is('*dashboard*')
	];
	$enlaces[] = [
		'name' => 'Feedback',  
		'icon' => '<i class="fas fa-comment-dots mr-2 w-4"></i>', 
		'link' => route('admin.feedbacks.index'),
		'active' => request()->is('admin/feedbacks*'),
		'badge' => App\Models\Feedback::where('reviewed', 0)->count(),
		'end_section' => true
	];
	$enlaces[] = [ 
		'name' => 'Planes de mantenimiento',  
		'icon' => '<i class="fas fa-layer-group mr-2 w-4"></i>', 
		'link' => route('admin.maintenance-plans.index'), 
		'active' => request()->is('admin/maintenance-plans*')
	];
	$enlaces[] = [
		'name' => 'Operaciones',  
		'icon' => '<i class="fas fa-wrench mr-2 w-4"></i>', 
		'link' => route('admin.universal-operations.index'), 
		'active' => request()->is('admin/universal-operations*'),
		'end_section' => false
	];
	$enlaces[] = [
		'name' => 'Recambios',  
		'icon' => '<i class="fas fa-space-shuttle mr-2 w-4"></i>', 
		'link' => route('admin.spare-parts.index'), 
		'active' => request()->is('admin/spare-parts*'),
		'end_section' => true
	];
	$enlaces[] = [
		'name' => 'Flotas',  
		'icon' => '<i class="fas fa-campground mr-2 w-4"></i>', 
		'link' => route('admin.fleets.index'),
		'active' => request()->is('admin/fleets*')
	];
	$enlaces[] = [
		'name' => 'Usuarios',  
		'icon' => '<i class="fas fa-users mr-2 w-4"></i>', 
		'link' => route('admin.users.index'),
		'active' => request()->is('admin/users*')
	];
	$enlaces[] = [
		'name' => 'Marcas y Modelos',  
		'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
		'link' => route('admin.manufacturers.index'),
		'active' => false
	];
	$enlaces[] = [
		'name' => 'Familias',  
		'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
		'link' => route('admin.families.index'),
		'active' => false
	];

@endphp

@extends('layouts.master', ['nav_items' => $enlaces])

@section('app')
	@include('shared.alerts')

	@yield('progress')

	<main>
		@yield('content')
		
		<br><br><br>
	</main>
@endsection
