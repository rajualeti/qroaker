<?php

Admin::model('App\BlockQroakUserReason')->title('Block Qroak User Reasons')->as('blockqroakuserreasons')->columns(function ()
{
	Column::string('reason', 'Reason');
	Column::string('status', 'Status');
	
})->form(function ()
{
	FormItem::text('reason', 'Reason')->required();
	FormItem::select('status', 'Status')->list(['1'=>'Active', '0'=>'Inactive'])->required();
});
