<?php

Admin::model('App\ReportProfileReason')->title('Block Profile Reasons')->as('blockprofilereasons')->columns(function ()
{
	Column::string('reason', 'Reason');
	Column::string('status', 'Status');
	
})->form(function ()
{
	FormItem::text('reason', 'Reason')->required();
	FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
});
