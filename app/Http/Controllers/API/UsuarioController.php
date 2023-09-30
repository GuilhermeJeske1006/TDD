<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(UsuarioResource::collection(User::all()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:100',
                'email' => 'required|string|email|unique:users', 
                'password' => 'required|min:8',
            ]);
    
            $user = User::create($validatedData);
    
            if ($user) {
                return response()->json(["message" => "Usuário criado com sucesso", "data" => $user], 201);
            }

        }catch (\Exception $e) {

            return response()->json(["message" => "Erro ao criar usuário", "data" => $e], 500);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:100',
                'email' => 'required|string|email|unique:users,email,' . $user->id,
                'password' => 'required|min:8',
            ]);

            $user->update($validatedData);

            return response()->json(["message" => "Usuário atualizado com sucesso", "data" => $user], 200);
        } catch (\Exception $e) {

            return response()->json(["message" => "Erro ao atualizar usuário", "erro" => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json(["message" => "Usuário removido com sucesso", "data" => $user], 200);
        } catch (\Exception $e) {

            return response()->json(["message" => "Erro ao remover usuário", "erro" => $e], 500);
        }
    }
}
