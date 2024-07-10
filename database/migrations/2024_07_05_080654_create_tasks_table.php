<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id'
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cria a coluna 'user_id' e define a chave estrangeira
            $table->string('task');
            $table->string('status');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->string('priority')->nullable();
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
