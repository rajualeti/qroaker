<?php

// Create admin model from User class with title and url alias
Admin::model('App\State')->title('States')->as('states')
	->columns(function ()
	{
		// Describing columns for table view
		Column::string('state', 'State');
		Column::string('status', 'Status');
	})->form(function ()
	{
		// Describing elements in create and editing forms
		FormItem::text('state', 'State')->required();
		FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
	});