<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
     /**
     * Show the update profile page.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     *
     *
     */

    public function index()
    {

        return redirect()->route('profile.edit');
    }

     public function editView()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        // dd($user);
        return view('profile.edit', compact('user'))->with('success', 'User profile has been updated.');
    }

    public function edit(Request $request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $request->validate([
            'phone' => 'required|min:10|numeric',
            'password' => 'same:confirm-password',
        ]);
        $input = $request->all();
        if(!empty($input['password']))
        {
            $input['password'] = Hash::make($input['password']);
        }
        else
        {
            $input = Arr::except($input,array('password'));
        }
        if($request->hasFile('image'))
        {
            $dataimage = public_path('/image/').$user->image;
            if(file_exists($dataimage))
            {
                @unlink($dataimage);
            }
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $tujuan_upload = 'image';
            $file->move($tujuan_upload,$file->getClientOriginalName());
            $user->image = $filename;
            $input['image'] = $user->image;
        }
        $user->update($input);
        return redirect('/profile')->with('success', 'User profile has been updated.');
    }

    public function update(Request $request, $id)
    {

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' =>'required|string|min:10',
    //         'email' => 'required|email|max:255',
    //         'password' =>'required|string|min:15'
    //     ]);
    //     $user = User::findOrFail($id);
    //     $dataimage = public_path('/image/').$user->image;
    //     if(file_exists($dataimage))
    //     {
    //         @unlink($dataimage);
    //     }
    //     if($request->hasFile('image'))
    //     {
    //         $file = $request->file('image');
    //         $user->image = $file->getClientOriginalName();
    //         $tujuan_upload = 'image';
	//         $file->move($tujuan_upload,$file->getClientOriginalName());
    //     }
    //     $user->update($request->all());


    //     $Photos = Photo::findOrFail($id);

    //     $Photos->update($request->all());


    //     return redirect()->route('profile.edit')->with('success','User Profile updated successfully');
    // }

    // public function photoUpload(Request $request,$id)
    // {
    //     $Photos = Photo::findOrFail($id);
    //     $Photos->update($request->all());

    //     return redirect()->route('profile.edit')->with('success','User Profile updated successfully');

    // }
}
}
