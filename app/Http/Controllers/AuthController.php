<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\RolePermission;
use App\Role;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', [
        	'except' => [
        		'login', 
        		'register'
        	]
        ]);
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:192',
            'password' => 'required|string|min:6'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $credentials = $req->only('username', 'password');
            $user = User::where(['username'=> $req['username']])->first();

            if ($user) 
            {
                if (Hash::check($req['password'], $user->password)) 
                {
                    $data = User::GetUserWithEmail($user['email']);
                    $permission = RolePermission::GetAllSmallByID(1000, 0, $data['role_id']);
                    $role = Role::where(['id' => $data['role_id']])->first();

                    $response = [
                        'message' => 'login success',
                        'status' => 'ok',
                        'code' => '201',
                        'data' => [
                            'user' => $data,
                            'role' => $role,
                            'permissions' => $permission,
                            'token' => $user->createToken('my-token')->plainTextToken
                        ]
                    ];
                }
                else 
                {
                    $response = [
                        'message' => 'check back your password',
                        'status' => 'password-invalid',
                        'code' => '201',
                        'data' => []
                    ];
                }
            }
            else 
            {
                $response = [
                    'message' => 'check back your email address',
                    'status' => 'email-invalid',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:64|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        }
        else 
        {
            $data = [
                'name' => $req['name'],
                'email' => $req['email'],
                'password' => Hash::make($req['password']),
                // 'username' => explode('@', $req['email'])[0],
                'username' => $req['username'],
                'enabled' => false,
                'role_id' => '2'
            ];

            $rest = User::insert($data);
            if ($rest) 
            {
                $response = [
                    'message' => 'register success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => []
                ];
            }
            else 
            {
                $response = [
                    'message' => 'register failed',
                    'status' => 'unauthorized',
                    'code' => '201',
                    'data' => []
                ];
            }
        }
     
        return response()->json($response, 200);
    }

    public function logout(Request $req)
    {
        $user = $req->user();
        $user->currentAccessToken()->delete();
        $response = [
            'message' => 'logout successfully',
            'status' => 'ok',
            'code' => '201',
            'data' => []
        ];

        return response()->json($response, 200);
    }

    public function me(Request $req)
    {
        $user = $req->user();
        $data = User::GetUserWithEmail(Auth()->user()->email);
        $permission = RolePermission::GetAllSmallByID(1000, 0, $data['role_id']);
        $role = Role::where(['id' => $data['role_id']])->first();
        $token = $user->currentAccessToken();

        $response = [
            'message' => 'process success',
            'status' => 'ok',
            'code' => '201',
            'data' => [
                'token' => $token,
                'user' => $data,
                'role' => $role,
                'permissions' => $permission
            ]
        ];
     
        return response()->json($response, 200);
    }
}
