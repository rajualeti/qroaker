<?php


/*
 * Describe your menu here.
 *
 * There is some simple examples what you can use:
 *
 * 		Admin::menu()->url('/')->label('Start page')->icon('fa-dashboard')->uses('\AdminController@getIndex');
 * 		Admin::menu(User::class)->icon('fa-user');
 * 		Admin::menu()->label('Menu with subitems')->icon('fa-book')->items(function ()
 * 		{
 * 			Admin::menu(\Foo\Bar::class)->icon('fa-sitemap');
 * 			Admin::menu('\Foo\Baz')->label('Overwrite model title');
 * 			Admin::menu()->url('my-page')->label('My custom page')->uses('\MyController@getMyPage');
 * 		});
 */

Admin::menu()->url('/')->label('Welcome')->icon('fa-dashboard')->uses('App\Http\Controllers\AdminController@index');

Admin::menu()->label('Lookups')->icon('fa-globe')->items(function ()
{
	Admin::menu(App\BlockQroakReason::class)->icon('fa-ban');
	Admin::menu(App\BlockQroakUserReason::class)->icon('fa-ban');
	Admin::menu(App\BlockUserReason::class)->icon('fa-ban');
	Admin::menu(App\ReportCommentReason::class)->icon('fa-user');
	Admin::menu(App\ReportProfileReason::class)->icon('fa-user');
	Admin::menu(App\ReportQroakReason::class)->icon('fa-user');
	Admin::menu(App\UserWarning::class)->icon('fa-exclamation-triangle');
	Admin::menu(App\State::class)->icon('fa-globe');
	
});
Admin::menu(App\Setting::class)->label('System Variables')->icon('fa-cog');
