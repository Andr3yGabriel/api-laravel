<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Retorna uma lista paginada de usuários.
     *
     * Este método recupera uma lista paginada de usuários do banco de dados e a retorna como uma resposta JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        // Recupera os dados do banco de dados
        $users = User::select('id', 'name')->orderBy('id', 'DESC')->paginate(2);

        // Retorna os dados do banco
        return response()->json([
            'status' => true,
            'message'=> $users,
        ],200);
    }

    /**
     * Exibe as informações detalhados de um usuário específico
     *
     * Este método retorna esses detalhes em formato de JSON
     *
     * @param \App\Models\User $user O objeto do usuário a ser exibido
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        try {
            // Retorna os dados do banco
            return response()->json([
                'status' => true,
                'message'=> $user,
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> 'Não é possível adquirir os dados desse usuário' . $e->getMessage(),
            ],400);
        }
    }

    public function register(UserRequest $request) : JsonResponse
    {
        // Iniciar a transação
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Certifique-se de que a senha está encriptada
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token,
                'message' => 'Usuário cadastrado com sucesso!',
            ], 201);

        } catch (Exception $e) {
            // Não conclui a operação
            DB::rollBack();

            // Retorna mensagem de erro 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado! Erro: " . $e->getMessage(),
            ], 400);
        }
    }


    public function update(UserRequest $request, User $user) : JsonResponse
    {
        DB::beginTransaction();

        try {
            $user->update([
                "name"=> $request->name,
                "email"=> $request->email,
                "password"=> $request->password,
            ]);

            DB::commit();

            return response()->json([
                "status"=> true,
                "user"=> $user,
                "message"=> "Usuário editado com sucesso!",
            ],200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                "status"=> false,
                "message"=> "Usuário não editado!" . $e->getMessage(),
            ],400);
        }
    }

    public function destroy(User $user) : JsonResponse
    {
        try {
            $user->delete();

            return response()->json([
                "status"=> true,
                "user"=> $user,
                "message"=> "Usuário apagado com sucesso!",
            ],200);

        } catch (Exception $e) {
            return response()->json([
                "status"=> false,
                "message"=> "Usuário não foi excluído!" . $e->getMessage(),
            ],400);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where("email", $request->email)->first();

            // Verificação se o usuário existe e se a senha está correta
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "status" => false,
                    "message" => "Credenciais inválidas!",
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token,
                'message' => 'Login autorizado!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
