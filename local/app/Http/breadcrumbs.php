<?php

Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::register('business.index', function($breadcrumbs)
{
    $breadcrumbs->push('Business', route('business.index'));
    $breadcrumbs->push('Home', route('home'));
});
Breadcrumbs::register('business.show', function($breadcrumbs)
{
	$breadcrumbs->push('Business Profile', route('business.show'));
	$breadcrumbs->parent('business.index');
});
Breadcrumbs::register('trucks.index', function($breadcrumbs)
{
	$breadcrumbs->push('Trucks List', route('trucks.index'));
});
Breadcrumbs::register('trucks.create', function($breadcrumbs)
{
	$breadcrumbs->parent('loads.index');
	$breadcrumbs->push('Post Truck', route('trucks.create'));
});
Breadcrumbs::register('loads.index', function($breadcrumbs)
{
	$breadcrumbs->push('Loads List', route('loads.index'));
});
Breadcrumbs::register('loads.create', function($breadcrumbs)
{
	$breadcrumbs->parent('loads.index');
	$breadcrumbs->push('Post Load', route('loads.create'));
});
Breadcrumbs::register('users.index', function($breadcrumbs)
{
	$breadcrumbs->push('Users List', route('users.index'));
	$breadcrumbs->push('Home', route('home'));
});
Breadcrumbs::register('roles.index', function($breadcrumbs)
{
	$breadcrumbs->push('Roles List', route('roles.index'));
});
Breadcrumbs::register('users.show', function($breadcrumbs)
{
	$breadcrumbs->push('User Profile', route('users.show'));
	$breadcrumbs->parent('users.index');
});
Breadcrumbs::register('tasks.index', function($breadcrumbs)
{
	$breadcrumbs->push('Trucks List', route('tasks.index'));
});
Breadcrumbs::register('field-verification.index', function($breadcrumbs)
{
	$breadcrumbs->push('Field Verification List', route('field-verification.index'));
});
Breadcrumbs::register('customer-dashboard.index', function($breadcrumbs)
{
	$breadcrumbs->push('Customer Dashboard', route('customer-dashboard.index'));
});
?>