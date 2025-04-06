<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class AuthController extends Controller
{
    // Registro de usuário
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    //Login de usuário
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ]
        ]);
    }
    

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    // Verificação de dois fatores
    public function envioCodigoDoisFatores(Request $request)
    {
        $user = $request->user();
        $user->codigo_dois_fatores = rand(100000, 999999);
        $user->codigo_experia_em = Carbon::now()->addMinutes(10);
        $user->save();
    
        Mail::to($user->email)->send(new TwoFactorCodeMail($user->codigo_dois_fatores));
    
        return response()->json(['message' => 'Código enviado para seu e-mail.']);
    }

    public function verificacaoCodigoDoisFatores(Request $request)
    {
        $user = $request->user();

        if ($request->code == $user->codigo_dois_fatores && Carbon::now()->lt($user->codigo_experia_em)) {
            $user->codigo_dois_fatores = null;
            $user->codigo_experia_em = null;
            $user->save();

            return response()->json(['message' => 'Código de autenticação validado com sucesso!']);
        }

        return response()->json(['message' => 'Código inválido ou expirado!'], 401);
    }

}
