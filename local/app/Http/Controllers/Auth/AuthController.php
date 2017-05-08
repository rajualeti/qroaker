<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;
	protected $redirectAfterLogout;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		
		$this->redirectAfterLogout = '/';
		
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [ 'field' =>'required', 'password' => 'required', ]);
	
		$field = !(filter_var($request->input('field'), FILTER_VALIDATE_EMAIL)) ? 'mobile' : 'email';
	
		if (Auth::attempt(array($field=> $request->input('field'), 'password' => $request->input('password'), 'status' => 1, 'is_deleted' => 0), $request->has('remember'))) {
	
			$redirect_path = Redirect::back();
	
			if($request->input('log'))
			{
				return $redirect_path;
			}
			else
			{
				return redirect()->to($this->redirectPath($redirect_path));
			}
		}
		if (Auth::validate(array($field=> $request->input('field'), 'password' => $request->input('password'), 'status' => 0), $request->has('remember'))) 
		{
			return redirect($this->loginPath())
				->withInput($request->only($field, 'remember'))
				->withErrors([
						$field => sprintf(Lang::get('welcome.inactive_user'), Config::get('constants.phone-number')),
				]);
		}
		else
		{
			return redirect($this->loginPath())
				->withInput($request->only($field, 'remember'))
				->withErrors([
						$field => sprintf(Lang::get('welcome.user_not_found'), Config::get('constants.phone-number')),
				]);
		}
	
	}
	
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}
	
		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
	}
	
	public function getLogout()
	{
		
		$this->auth->logout();
	
		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}
	
	
	
}
