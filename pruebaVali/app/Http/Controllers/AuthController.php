<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validate)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            Auth::login($user);

            return response()->json(['status' => 'success', 'token' => $token, 'user' => $user], 200);

        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = new User();

            $user->name = $validate['name'];
            $user->surname = $validate['surname'];
            $user->email = $validate['email'];
            $user->password = $validate['password'];

            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            //Enviar correo de bienvenida
            $this->mailService = new MailService();
            $emailSent = $this->mailService->enviarMail($user->name, $user->email);


            DB::commit();

            return response()->json(['status' => 'success', 'token' => $token ,'user' => $user, 'message' => 'Usuario creado', 'email_status' => $emailSent], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
