<?php

Admin::model('App\Setting')->title('System Variables')->as('system-variables')
	->denyCreating()
	->denyDeleting()
	->columns(function ()
	{
		Column::string('name', 'Setting Name');
		/* Column::string('key', 'key'); */
		Column::string('value', 'Value');
		Column::string('status', 'Status');
	})->form(function ()
	{
		FormItem::text('name', 'Setting Name')->required();
		/* FormItem::text('key', 'Key')->required(); */
		FormItem::text('value', 'Value')->required();
		FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
		
	});