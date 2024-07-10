<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Task::where("id","=",1)->exists())
        {
            Task::create([
                'user_id' => 1,
                'task'=> 'Apresentação 3',
                'status'=> 'Em andamento',
                'description'=> 'Apresentação sobre PHP, Laravel, Android e código limpo',
                'deadline'=> date('Y-m-d', mktime(0,0,0,7,5,2024)),
                'priority'=> 'alta',
            ]);
        }
    }
}
