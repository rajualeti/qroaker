<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Qroak;
use Illuminate\Support\Facades\DB;

class QroakController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/* $string = "I am #UberSilly and #MegaPlayful online";
		
		echo convert_hashtag($string); */
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Auth::check()) {
			
			$user = Auth::user();
		
			if($user->can('create-qroak') || $user->hasRole('admin')) {
			
				$data = Input::all();
				
				$qroak_data = [
							'user_id'		=> Auth::id(),
							'qroak_text' 	=> $data['qroak_text'],
							'is_classified' => isset($data['is_classified']) ? $data['is_classified'] : 0,
							'is_private' 	=> isset($data['is_private']) ? $data['is_private'] : 0,
							'status'		=> 1,
							'created_by' 	=> Auth::id(),
							'created_at'	=> date('Y-m-d H:i:s')
				];
				
				$validator = Validator::make($qroak_data, Qroak::$rules, Qroak::$messages);
				
				if ($validator->fails()) {
				
					return redirect()->back()->withInput($data)->withErrors($validator->errors());
					
				}
				
				try {
				
					DB::beginTransaction();
					
					$qroak = Qroak::create($qroak_data);				
					
					if(isset($qroak->qroak_id)) {
							
						/* if ( Input::hasFile('profile_image')) {
								
							$file = Input::file('profile_image');
							$user_name = str_slug($data['name']);
							$name = $user->id.'.png';
							$path = 'images/profile-images/'. $name;
							$image = Image::make($file->getRealPath())->resize(200, 200)->save($path);
							$profile_image = 'images/profile-images/'.$name;
								
							User::where('id', $user->id)->update(['image' => $profile_image]);
						} */
							
						DB::commit();
							
						return redirect('/')->with('success_message', 'Qroak successfully posted.');
					}
					else {
						DB::rollBack();
							
						return redirect()->back()->withInput($data)->withErrors('Something went wrong');
					}
				
				}
				catch (QueryException $e) {
					DB::rollBack();
					return redirect()->back()->withInput($data)->withErrors("QueryException: ".$e->getMessage()." on file ".$e->getFile().' in line no '.$e->getLine());
				}
				catch (\Exception $e) {
					DB::rollBack();
					return redirect()->back()->withInput($data)->withErrors("Exception: ".$e->getMessage()." on file ".$e->getFile().' in line no '.$e->getLine());
				}
			} else {
				return [ 'status' => 'error', 'msg' => 'Access denied!' ];
			}
		} else {
			return view('auth/login');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
