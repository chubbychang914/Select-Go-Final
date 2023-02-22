<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Email;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // *** Constructor function =========================================================================
    // The method is being used to apply the "auth:api" middleware to all routes in the controller, 
    // with the exception of the "login" and "register" routes. 
    // This means that for any routes in this controller other than "login" and "register",
    // the user must be authenticated with the "api" guard in order to access them.
    // ==================================================================================================
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    // *** Register function ============================================================================
    // 1. 驗證 Request 表單
    // 2. 建立新 User
    // 3. 回傳 Response
    // ==================================================================================================
    public function register(Request $request)
    {
        // 驗證表單資料是否符合格式
        $validated = $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'user_phone'    => ['nullable', 'regex:/^(?:\+886|09)[0-9]{8,9}$/'],
            'user_gender'   => 'nullable|string',
            'user_birthday' => 'nullable|string'
        ], [
                // 'email.email'      => '信箱格式不正確',
                'email.email'      => 'wrong email format',
                // 'email.unique'     => '這個信箱已經有人使用了！',
                'email.unique'     => 'email taken',
                // 'password.min'     => '密碼長度至少需要 8 碼！',
                'password.min'     => 'wrong password format',
                // 'user_phone.regex' => '手機格式不符合'
                'user_phone.regex' => 'wrong phone format'
            ]);


        // 建立 new user into db
        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'user_phone'    => $validated['user_phone'],
            'user_gender'   => $validated['user_gender'],
            'user_birthday' => $validated['user_birthday'],
        ]);

        // 回傳 response
        return [
            'message' => 'Register successful',
            'user'    => $validated
        ];
    }


    // *** Login function ===============================================================================
    // when the user is successfully authenticated, the Auth facade attempt() method returns the 
    // JWT token. The generated token is retrieved and returned as JSON with the user object
    // ==================================================================================================
    public function login(Request $request)
    {
        // 1. 先驗證 form 的資料是否符合規格
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);
        // 2. get only the email and password fields from the request
        $credentials = $request->only('email', 'password');
        // 3. Auth 裡面的 attempt method -> will compare hashed pwd value in the database and pwd value passed in array
        //    if successful, the attempt method returns a JWT token
        $token = Auth::attempt($credentials);
        // 4. If wrong, show this response
        if (!$token) {
            return response()->json([
                'message' => 'Email or password is incorrect',
            ], 401);
        }
        // 5. If correct, show this response
        $user = Auth::user(); // this verifies the user
        return response()->json([
            'message'      => 'Login successful',
            'user'         => [
                'id'          => $user->id,
                'email'       => $user->email,
                'displayName' => $user->name,
                'photoURL'    => $user->user_icon
            ],
            'access_token' => $token
            // 'token'   => $this->respondWithToken($token) // respondWithToken is a protected function set below
        ]);
    }


    // *** Logout function ==============================================================================
    // Invalidate the token + logout
    // ==================================================================================================
    public function logout()
    {
        // In Laravel, auth() is a helper function that returns an instance of the authentication guard. 
        // The guard is responsible for checking the user's credentials and maintaining the user's login state.
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }



    // *** Get user function ==============================================================================
    // Get the authenticated User.
    // ==================================================================================================
    public function me()
    {
        return response()->json(auth()->user());
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // a function that shows the token information
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    // ===============================================================================================================
    // 新增使用者的資料
    // ===============================================================================================================
    // public function getUser()
    // {
    //     $getuser = DB::table('users')
    //         ->select(
    //             'name',
    //             'email',
    //             'user_nickname as nickname',
    //             'user_phone as phone',
    //             'user_gender as gender',
    //             'user_birthday as birthday',
    //             'user_city as city',
    //             'user_address as address',
    //             'user_icon as photoURL'
    //         )
    //         ->get();

    //     return $getuser;
    // }

    public function fetchUserInfo($uid)
    {
        return User::where('id', '=', $uid)->get();
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->user_nickname = $request->user_nickname;
        $user->user_phone = $request->user_phone;
        $user->user_gender = $request->user_gender;
        $user->user_birthday = $request->user_birthday;
        $user->user_city = $request->user_city;
        $user->user_address = $request->user_address;
        $user->save();
        return response()->json(['message' => 'User updated successfully'], 200);
    }


    public function listAllUsers()
    {
        return User::all();
    }

    public function singleUserData($uid)
    {
        return User::where('id', '=', $uid)->get();
    }
}