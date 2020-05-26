<?php

namespace App\Http\Controllers;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // show your magic here
    }

    /**
     * Show all data users
     *
     * @return void
     */
    public function show()
    {
        $data = User::all();
        return response()->json($data);
    }

    /**
     * Create a new user account
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $username = $request->post('username');
        $name     = $request->post('name');
        $email    = $request->post('email');
        $password = $request->post('password');

        $this->validate($request, [
            'name'     => 'required|min:4',
            'email'    => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        
        $user           = new User;
        $user->uuid     = Uuid::uuid4()->getHex();
        $user->username = $username;
        $user->name     = $name;
        $user->email    = $email;
        $user->password = Hash::make($password);

        if ($user->save()) {
            $response = [
                'error'   => false,
                'message' => 'Successfully created user account'
            ];
        } else {
            $response = [
                'error'   => true,
                'message' => 'Error when create new user'
            ];
        }
        return response()->json($response);
    }

    /**
     * Show data for editing
     *
     * @url /user/{id}/edit
     * 
     * @param Request $request
     * @return void
     */
    public function edit(Request $request)
    {
        $id = $request->id;

    }

    /**
     * Update data user
     *
     * @method PUT | PATCH
     * 
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $id = $request->id;
        
    }

    /**
     * Delete data user
     *
     * @method DELETE
     * 
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

    }
}
