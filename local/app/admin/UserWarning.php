<?php

Admin::model('App\UserWarning')->title('User Warnings')->as('userwarnings')->columns(function ()
{
	Column::string('warning', 'Warning');
	Column::string('status', 'Status');
	
})->form(function ()
{
	FormItem::text('warning', 'Warning')->required();
	FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
});
