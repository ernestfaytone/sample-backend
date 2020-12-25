<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;

// JWT contract
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * Update a User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function updateUser($request){
        $user = User::where('id',$request->id)->first();

        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'message' => 'User successfully updated',
            'user' => $user
        ], 201);
    }

    /**
     * Delete user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($request){
        $user = User::find($request->all()[0]);
        $user->forceDelete();
        return response()->json(['message' => 'Succesfully deleted user.']);
    }


    public function registerUser($validator, $request){
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


}
