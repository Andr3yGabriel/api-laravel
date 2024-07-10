<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show() : JsonResponse
    {
        // Obter o usuário autenticado
        $user = Auth::user();

        // Buscar tarefas associadas ao usuário autenticado
        $tasks = Task::select('id', 'task', 'deadline')->where('user_id', $user->id)->orderBy("id", "DESC")->paginate(10);

        return response()->json([
            'status' => true,
            'tasks' => $tasks,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        DB::beginTransaction();

        try {
            // Obter o usuário autenticado
            $user = Auth::user();

            // Criar a tarefa associada ao usuário autenticado
            $task = Task::create([
                'task' => $request->task,
                'description' => $request->description,
                'status' => $request->status,
                'deadline' => $request->deadline,
                'priority' => $request->priority,
                'user_id' => $user->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'task' => $task,
                'message' => 'Tarefa adicionada com sucesso',
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'A tarefa não foi adicionada ' . $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, Task $task) : JsonResponse
    {
        DB::beginTransaction();

        try {
            $task->update([
                'task' => $request->task,
                'description'=> $request->description,
                'status'=> $request->status,
                'deadline' => $request->deadline,
                'priority'=> $request->priority,
            ]);

            DB::commit();

            return response()->json([
                'status'=> true,
                'task'=> $task,
                'message'=> 'Tarefa editada com sucesso!',
            ],200);
        } catch (Exception $e)
        {
            DB::rollBack();

            return response()->json([
                'status'=> false,
                'message'=> 'Tarefa não editada!' . $e->getMessage(),
            ],400);
        }
    }

    public function destroy(Task $task)
    {
        DB::beginTransaction();

        try{
            $task->delete();

            return response()->json([
                'status'=> true,
                'message'=> 'Tarefa apagada com sucesso!',
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> 'A tarefa não foi excluída!'. $e->getMessage(),
            ],400);
        }
    }
}
