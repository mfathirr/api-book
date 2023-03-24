<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // public function register(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:8',
    //         'username' => 'required|unique:users',
    //         'firstname' => 'required',
    //         'lastname' => 'nullable'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $user = User::create([
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'username' => $request->username,
    //         'firstname' => $request->firstname,
    //         'lastname' => $request->lastname
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     if($user) {
    //         return response()->json([
    //             'success' => true,
    //             'user'    => $user, 
    //             'token' => $token
    //         ], 201);
    //     }

    //     return response()->json([
    //         'success' => false,
    //     ], 409);
    // }

    // public function login(Request $request) {
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // $user = User::where(function ($query) use ($request) {
    //     //         $query->where('email', $request->email)
    //     //               ->orWhere('username', $request->username);
    //     //     })
    //     //     ->first();
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'account' => ['The provided credentials are incorrect'],
    //         ]);
    //     }

    //     return $user->createToken('logged in!')->plainTextToken;
    // }

    // public function logout(Request $request){
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json([
    //         'message' => 'Logout success'
    //     ]);
    // }

     public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }
    }

    public function login(Request $request)
    {
        // if (!Auth::attempt($request->only('username', 'password')))
        // {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        // $user = User::where('username', $request['username'])->firstOrFail();

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()
        //     ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
        $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    // method for user logout and delete token
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
