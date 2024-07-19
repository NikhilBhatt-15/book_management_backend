<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'refresh', 'logout','register']]);
    }

    public function register(Request $request){
        $admin = new Admin();
        $admin->name =$request->name;
        $admin->email =$request->email;
        $admin->password =Hash::make($request->password);
        $admin->save();

        return response()->json($admin,201);

    }
    public function profile(){
        Auth::guard('admin')->check();
        return Auth::guard('admin')->user();
    }
    // login generate jwt token after validating details
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        // return JWTAuth::toUser($token);
        return $this->respondWithToken($token);
    }

    // logout delete the jwt token
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function updateProfile(Request $request){
        Auth::guard('admin')->check();
        $admin  = Auth::guard('admin')->user();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();
        return response()->json($admin);
    }
    protected function respondWithToken($token)
    {
        Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}
