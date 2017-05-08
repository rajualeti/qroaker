<?php

Admin::model('App\ReportCommentReason')->title('Report Comment Reasons')->as('reportcommentreasons')->columns(function ()
{
	Column::string('reason', 'Reason');
	Column::string('status', 'Status');
	
})->form(function ()
{
	FormItem::text('reason', 'Reason')->required();
	FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
});
