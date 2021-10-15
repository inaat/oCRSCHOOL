<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return response([
                'users' => User::all(),
                'success' => 1
            ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required | string ',
            'email'    => 'required | email | unique:users',
            'password' => 'required | confirmed',
            'role'     => 'required'
        ]);
        
        // store user information
        $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password)
                ]);

        // assign new role to the user
        $role = $user->assignRole($request->role);

        if($user){
            return response([
                'message' => 'User created succesfully!',
                'user'    => $user,
                'success' => 1
            ]);
        }

        return response([
                'message' => 'Sorry! Failed to create user!',
                'success' => 0
            ]);
    }

    public function profile($id, Request $request)
    {
        $user = User::find($id);
        if($user)
            return response(['user' => $user,'success' => 1]);
        else
            return response(['message' => 'Sorry! Not found!','success' => 0]);
    }


    public function delete($id, Request $request)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response(['message' => 'User has been deleted','success' => 1]);
        }
        else
            return response(['message' => 'Sorry! Not found!','success' => 0]);
    }


    public function changeRole($id,Request $request)
    {
        $request->validate([
            'roles'     => 'required'
        ]);
        
        // update user roles
        $user = User::find($id);
        if($user){
            // assign role to user
            $user->syncRoles($request->roles);    
            return response([
                'message' => 'Roles changed successfully!',
                'success' => 1
            ]);
        }

        return response([
                'message' => 'Sorry! User not found',
                'success' => 0
            ]);
    }
}
