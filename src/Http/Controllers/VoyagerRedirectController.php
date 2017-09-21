<?php

namespace VoyagerRedirects\Http\Controllers;

use Illuminate\Http\Request;
use VoyagerRedirects\Models\VoyagerRedirect;

class VoyagerRedirectController extends \App\Http\Controllers\Controller
{

	//***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse the redirects (B)READ
    //
    //****************************************

    public function browse(Request $request, VoyagerRedirect $redirects){

    	$filter = $request->filter;
    	$sorting = $request->sorting;

    	if(isset($request->filter)){
    		$sorting = isset($sorting) ? $sorting : 'asc';
    		$redirects = $redirects->orderBy($filter, $sorting);
    	}

    	$redirects = $redirects->paginate(20);

    	//dd($redirects);

    	return view('voyager.redirects::browse', compact('redirects', 'filter', 'sorting'));
    }


    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //      Read a specific redirect B(R)EAD
    //
    //****************************************

    // No read view needed for this functionality


    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //          Edit a redirect BR(E)AD
    //
    //****************************************

    public function edit($id){
    	$redirect = VoyagerRedirect::find($id);
    	return view('voyager.redirects::edit-add', compact('redirect'));
    }

    // BR(E)AD POST REQUEST
    public function edit_post(Request $request){
    	$redirect = VoyagerRedirect::find($request->id);
    	$redirect->from = trim(trim($request->from), '/');
    	$redirect->to = trim(trim($request->to), '/');
    	$redirect->type = $request->type;
    	$redirect->save();

    	return redirect()
    			->back()
    			->with([
                        'message'    => "Successfully Updated Redirect",
                        'alert-type' => 'success',
                    ]);
    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    //          Add a new redirect BRE(A)D
    //
    //****************************************

    public function add(){
    	return view('voyager.redirects::edit-add');
    }

    // BRE(A)D POST REQUEST
    public function add_post(Request $request){
    	$redirect = new VoyagerRedirect;
    	$redirect->from = trim(trim($request->from), '/');
    	$redirect->to = trim(trim($request->to), '/');
    	$redirect->type = $request->type;
    	$redirect->save();

    	return redirect()
    			->route('voyager.redirects.edit', $redirect->id)
    			->with([
                        'message'    => "Successfully Created Redirect",
                        'alert-type' => 'success',
                    ]);
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //          Delete a redirect BREA(D)
    //
    //****************************************

    public function delete(Request $request){
        $id = $request->id;
        $data = VoyagerRedirect::destroy($id)
            ? [
                'message'    => "Successfully Deleted Redirect",
                'alert-type' => 'success',
            ]
            : [
                'message'    => "Sorry it appears there was a problem deleting this redirect",
                'alert-type' => 'error',
            ];

        return redirect()->route("voyager.redirects")->with($data);
    }

}
