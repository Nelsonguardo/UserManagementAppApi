<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Crear un nuevo usuario
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'mobile' => 'nullable|digits:10',
            'id_number' => 'required|max:11',
            'date_of_birth' => 'required|date|before:-18 years',
            'city_code' => 'required|numeric',
            'city_id' => 'nullable|numeric', // Nueva regla para city_id
            'department_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        // Si la validación falla, devolver los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear un nuevo usuario con los datos proporcionados
        $user = User::create([
            'email' => trim(strtolower($request->email)),
            'name' => trim(ucfirst($request->name)),
            'last_name' => trim(ucfirst($request->last_name)),
            'mobile' => $request->mobile,
            'id_number' => $request->id_number,
            'date_of_birth' => $request->date_of_birth,
            'city_code' => $request->city_code,
            'city_id' => $request->city_id, // Asignar city_id
            'department_id' => $request->department_id,
            'country_id' => $request->country_id,
            'password' => Hash::make($request->password), // Hash de la contraseña
            'is_admin' => false, // Por defecto, el usuario no es administrador
        ]);

        // Devolver una respuesta JSON indicando éxito y el usuario creado
        return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user]);
    }

    // Listar todos los usuarios
    public function index()
    {
        // Obtener todos los usuarios
        $users = User::all();
        // Devolver una respuesta JSON con todos los usuarios
        return response()->json($users);
    }

    // Mostrar un usuario individual
    public function show($id)
    {
        // Buscar el usuario por su ID
        $user = User::find($id);

        // Si el usuario no existe, devolver un mensaje de error
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Si el usuario existe, devolver sus datos en formato JSON
        return response()->json($user);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        // Buscar el usuario por su ID
        $user = User::find($id);

        // Si el usuario no existe, devolver un mensaje de error
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Validar los datos de la solicitud para la actualización
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'mobile' => 'nullable|digits:10',
            'id_number' => 'required|max:11',
            'date_of_birth' => 'required|date|before:-18 years',
            'city_code' => 'required|numeric',
            'city_id' => 'nullable|numeric', // Nueva regla para city_id
            'department_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'password' => 'nullable|string|min:8', // Permitir contraseña opcional
        ]);

        // Si la validación falla, devolver los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Actualizar la contraseña solo si se proporciona en la solicitud
        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        // Actualizar otros campos del usuario
        $user->email = trim(strtolower($request->email));
        $user->name = trim(ucfirst($request->name));
        $user->last_name = trim(ucfirst($request->last_name));
        $user->mobile = $request->mobile;
        $user->id_number = $request->id_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->city_code = $request->city_code;
        $user->department_id = $request->department_id;
        $user->country_id = $request->country_id;
        $user->city_id = $request->city_id;

        // Guardar los cambios en la base de datos
        $user->save();

        // Devolver una respuesta JSON indicando éxito y el usuario actualizado
        return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user]);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $user = User::find($id);

        // Si el usuario no existe, devolver un mensaje de error
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Eliminar el usuario de la base de datos
        $user->delete();

        // Devolver una respuesta JSON indicando éxito
        return response()->json(['message' => 'Usuario eliminado exitosamente']);
    }
}
