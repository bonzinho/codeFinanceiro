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
        factory(\codeFin\User::class,1)  // user que é administrador
        	->states('admin')
        	->create([
        		'name' => 'Vitor Bonzinho',
        		'email' => 'admin@user.com'
        		]);

        factory(\codeFin\User::class,1)  // user que não é cliente apenas          
            ->create([
                'name' => 'Cliente da Silva',
                'email' => 'client@user.com'
                ]);
    }
}
