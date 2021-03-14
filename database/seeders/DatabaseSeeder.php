<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $role_id_admin = DB::table('roles')->insertGetId([
            'name' => 'admin_room_911',
            'code' => 'AD123',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        $role_id_normal = DB::table('roles')->insertGetId([
            'name' => 'user_room_911',
            'code' => 'AI232',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        $departments_id = DB::table('departments')->insertGetId([
            'name' => 'Medical',
            'code' => 'US321',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        $departments_id2 = DB::table('departments')->insertGetId([
            'name' => 'Administrative',
            'code' => 'US322',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        DB::table('users')->insert([
            'firstname' => 'Josue',
            'middlename' => 'David',
            'lastname' => 'Oviedo',
            'identification' => '1102832744',
            'email' => 'josuedor@gmail.com',
            'password' => Hash::make('secret'),
            'status' => 'enabled', //disabled
            'roles_id' => $role_id_admin,
            'departments_id' => $departments_id,
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);

        for ($i=0; $i < 30; $i++) { 
            DB::table('users')->insert([
                'firstname' => Str::random(10),
                'middlename' => Str::random(10),
                'lastname' => Str::random(10),
                'identification' => rand(11021234,999999999),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('secret'),
                'status' => 'enabled', //disabled
                'roles_id' => $role_id_normal,
                'departments_id' => $departments_id,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ]);
        }

        for ($i=0; $i < 10; $i++) { 
            $now = \Carbon\Carbon::now();
            DB::table('users')->insert([
                'firstname' => Str::random(10),
                'middlename' => Str::random(10),
                'lastname' => Str::random(10),
                'identification' => rand(11021234,999999999),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('secret'),
                'status' => 'enabled', //disabled
                'roles_id' => $role_id_normal,
                'departments_id' => $departments_id2,
                "created_at" =>  $now->addDays(5), # new \Datetime()
                "updated_at" =>$now->addDays(5),  # new \Datetime()
            ]);
        }

        for ($i=0; $i < 10; $i++) { 
            $now = \Carbon\Carbon::now();
            DB::table('users')->insert([
                'firstname' => Str::random(10),
                'middlename' => Str::random(10),
                'lastname' => Str::random(10),
                'identification' => rand(11021234,999999999),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('secret'),
                'status' => 'enabled', //disabled
                'roles_id' => $role_id_normal,
                'departments_id' => $departments_id,
                "created_at" =>  $now->addDays(13), # new \Datetime()
                "updated_at" =>$now->addDays(13),  # new \Datetime()
            ]);
        }

    }
}