<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class GymManagerController extends Controller
{
    public function create()
    {
        return view('gymManager.create', [
            'users' => User::all(),
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20',
            'password' => 'required |min:6',
            'email' => 'required|string|unique:users,email,',
            'national_id' => 'digits_between:10,17|required|numeric|unique:users',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg',
        ]);
        if ($request->hasFile('profile_image') == null) {
            $imageName = 'imgs/defaultImg.jpg';
        } else {
            $image = $request->file('profile_image');
            $name = time() . \Illuminate\Support\Str::random(30) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/imgs');
            $image->move($destinationPath, $name);
            $imageName = 'imgs/' . $name;
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->profile_image = $imageName;
        $user->national_id = $request->national_id;
        $user->assignRole('gymManager');
        $user->save();

        return redirect()->route('gymManager.list');
    }

    public function list()
    {
        return view("gymManager.list");
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('gymManager.show', [
            'user' => $user,
        ]);
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        return view('gymManager.edit', [
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        $user = User::find($id);
        return view('gymManager.update', [
            'user' => $user,
        ]);
    }
    
    public function deletegymManager($id)
    {
        $user = User::find($id);
        return view('gymManager.delete', [
            'user' => $user,
        ]);
    }
}
