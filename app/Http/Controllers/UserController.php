<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\User;


class UserController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['findUser','register']]);
        $this->userModel = new User();
    }

    
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return $this->userModel->registerUser($validator, $request);
    }
    /**
     * Delete user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request){
        return $this->userModel->deleteUser($request);
    }

    /**
     * Get Users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userList() {
        return response()->json(User::get());
    }


    /**
     * Update a User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function updateUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email,'.$request->id
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        
        return $this->userModel->updateUser($request);
    }

    /**
     * Update a User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function findUser($id){
        return User::find($id);
    }

}
