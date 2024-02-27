<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Método para iniciar sesión
    public function login(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario por su correo electrónico
        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Devolver un mensaje de error si la autenticación falla
            return response()->json(['message' => 'No autorizado'], 401);
        }

        // Generar un token de autenticación para el usuario
        $token = $user->createToken('authToken')->plainTextToken;

        // Verificar si es el primer inicio de sesión del usuario (requiere cambio de contraseña)
        if ($user->is_first_time) {
            // Devolver un código de estado personalizado 402 y un mensaje indicando que se requiere un cambio de contraseña
            return response()->json(['is_first_time' => 'Primer inicio de sesión, se requiere cambio de contraseña', 'token' => $token], 402);
        }

        // Devolver un token de acceso y los datos del usuario en formato JSON
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'is_admin' => $user->is_admin,
            ],
        ]);
    }

    // Método para cambiar la contraseña del usuario autenticado
    public function changePassword(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
            'new_password_confirmation' => 'required_with:new_password|same:new_password'
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            // Devolver errores de validación si existen
            return response()->json($validator->errors(), 422);
        }

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            // Devolver un mensaje de error si la contraseña actual no coincide
            return response()->json(['message' => 'La contraseña actual no coincide'], 401);
        }

        // Actualizar la contraseña del usuario
        $user->password = Hash::make($request->new_password);
        $user->is_first_time = false; // Marcar que el usuario ya no está en su primer inicio de sesión
        $user->save(); // Guardar el usuario con la nueva contraseña

        // Devolver un mensaje de éxito
        return response()->json(['message' => 'Contraseña cambiada correctamente']);
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        // Eliminar todos los tokens de acceso del usuario autenticado
        $request->user()->tokens()->delete();
        
        // Devolver un mensaje de éxito
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
