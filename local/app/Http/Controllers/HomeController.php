<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Qroak;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$qroaks = Qroak::where('status', 1)->orderBy('qroak_id', 'DESC')->paginate(config('constants.records-per-page'));
		$popular = Qroak::where('status', 1)->orderBy('qroak_id', 'DESC')->take(5)->get();
		$trends = Qroak::where('status', 1)->paginate(config('constants.records-per-page'));
		
		return view('home', compact('qroaks','popular', 'trends'));
	}

	/**
	 * sending mail of contact us request.
	 *
	 * @return Response
	 */
	public function contactUs()
	{
		$data  = Input::all();
		
		$to = explode(',', config('constants.email'));
		
		Mail::send('emails.contact-us', compact('data'), function($message) use($to)
		{
			$message->to($to)->subject('Qroaker - Contact us request');
		});
		
		return redirect('/#contactForm')->with('success_message', 'Your request successfully sent.');
	}
	
	public function resetPassword($id)
	{
		$authuser = Auth::user();
	
		$user = User::find($id);
	
		$permission = '';
		if($user->user_type == 1) {
			$permission = 'reset-qroakuser-password';
		} else if($user->user_type == 2) {
			$permission = 'reset-user-password';
		}
	
		if($authuser->hasRole('admin') || $authuser->can($permission))
		{
			$password = generatepassword();
	
			$affected_rows = User::where('id', $id)->update(['password' => bcrypt($password)]);
	
			if($affected_rows > 0) {
	
				$data = ['email' => $user->email, 'password' => $password];
	
				$mail_to = $user->email;
	
				Mail::send('emails.reset-password', compact('data'), function($message) use($mail_to)
				{
					$message->to($mail_to)->subject('Qroaker - Password reset successfully');
				});
	
				return response(['msg'=>'Password reset successfully.', 'status'=>'success']);
			}
			else{
				return response(['msg'=>'Password not reset.', 'status'=>'error']);
			}
		} else {
			return response(['msg'=>'Access denied!', 'status'=>'error']);
		}
	}
	
	public function changePassword()
	{
		$user = Auth::user();
	
		if($user->hasRole('admin') || $user->can('change-password'))
		{
			return view('auth.change-password');
		}
		else
		{
			return View('errors.403');
		}
	}
	
	public function updatePassword()
	{
		$user = Auth::user();
	
		if($user->hasRole('admin') || $user->can('change-password'))
		{
			$data = Input::all();
				
			$rules = User::$password_rules;
			$messages = User::$password_messages;
				
			$validator = Validator::make($data, $rules, $messages);
				
			if ($validator->fails())
			{
				return redirect()->back()->withErrors($validator->errors());
			}
				
			if (Auth::validate(array('email' => $user->email, 'password' => $data['old_password'], 'status' => 1)))
			{
	
				$affected_rows = User::where('id', $data['id'])->update(['password'=>bcrypt($data['new_password'])]);
					
				if($affected_rows > 0) {
						
					$mobile = User::find($data['id'])->mobile;
	
					$data['email'] = $user->email;
					$data['password'] = $data['new_password'];
						
					$mail_to = $user->email;
						
					Mail::send('emails.change-password', compact('data'), function($message) use($mail_to)
					{
					$message->to($mail_to)->subject('Qroaker - Password changed successfully');
					});
	
					return redirect()->back()->with('success_message','Password changed successfully!');
				}
				else{
	
					return redirect()->back()->withErrors('Error occured!');
				}
			} else {
				return redirect()->back()->withErrors('Old password do to match with our records.');
			}
		} else {
			return View('errors.403');
		}
	}
}
