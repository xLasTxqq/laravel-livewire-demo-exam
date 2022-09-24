<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Создание ролей

        Role::create([
            'name'=>'user'
        ]);
        Role::create([
            'name'=>'admin'
        ]);

        //Создание админа

        $admin = User::create([
            'name'=>'admin',
            'surname'=>'admin',
            'login'=>'admin',
            'email'=>'admin@admin',
            'password'=>Hash::make('admin66')
        ]);

        $admin->assignRole('admin');

        //Создание статусов

        Status::create([
            'name'=>'Новый'
        ]);

        Status::create([
            'name'=>'Подтвержденный'
        ]);

        Status::create([
            'name'=>'Отмененный'
        ]);

        // Status::create([
        //     'name'=>'В корзине'
        // ]);
    }
}
