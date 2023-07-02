<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Brian2694\Toastr\Facades\Toastr;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255'],
            'role' => ['max:255'],
            'phone' => ['required', 'max:255'],
            'profile_picture' => ['image', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $image_data = file_get_contents($image);
            $image_base64 = base64_encode($image_data);
            $user->profile_picture = $image_base64;
        }

        $user->username = $request->get('username');
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->city = $request->get('city');
        $user->country = $request->get('country');
        $user->postal = $request->get('postal');
        $user->about = $request->get('about');
        $user->phone = $request->get('phone');

        $user->save();

        return back()->with('success', 'Profile successfully updated');
    }
}
