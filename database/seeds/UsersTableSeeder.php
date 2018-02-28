<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Dilermando Barbosa",
            'email' => "diler@gmail.com",
            'username' => "diler",
            'password' => bcrypt('secret'),
            'phone' => "30528085",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Fabio Siqueira",
            'email' => "fabio.siqueira@t-systems.com.br",
            'username' => "fabio",
            'password' => bcrypt('secret'),
            'phone' => "30528001",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Caroline Machado",
            'email' => "caroline.machado@t-systems.com.br",
            'username' => "carol",
            'password' => bcrypt('secret'),
            'phone' => "30528017",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Diogo Lessa",
            'email' => "diogo.lessa@t-systems.com.br",
            'username' => "diogo",
            'password' => bcrypt('secret'),
            'phone' => "30528095",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Gabriel Oliveira",
            'email' => "gabriel@gmail.com",
            'username' => "gabriel",
            'password' => bcrypt('secret'),
            'phone' => "99999999",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Ilgner Ilgney",
            'email' => "ilgner@t-systems.com.br",
            'username' => "ilgner",
            'password' => bcrypt('secret'),
            'phone' => "99999999",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Veronica Amarante",
            'email' => "veronica@t-systems.com.br",
            'username' => "veronica",
            'password' => bcrypt('secret'),
            'phone' => "99999999",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'name' => "Donald Trump",
            'email' => "donald@t-systems.com.br",
            'username' => "donald",
            'password' => bcrypt('secret'),
            'phone' => "99999999",
            'cell' => "99999999",
            'created_at' => new DateTime()
        ]);
    }
}
