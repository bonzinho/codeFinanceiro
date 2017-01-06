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
        $repository = app(\codeFin\Repositories\ClientRepository::class); // ir buscar os nossos clientes
        $clients = $repository->all(); // criar o objeto com todos os clientes
        factory(\codeFin\Models\User::class,1)  // user que é administrador
        	->states('admin')
        	->create([
        		'name' => 'Vitor Bonzinho',
        		'email' => 'admin@user.com'
        		]);

        foreach (range(1,50) as $value) {  // foreach para criar 50 utilizadores
            factory(\codeFin\Models\User::class,1)  // este factory cria um utilizador, o foreach é que vai fazer com que crie os vários 50*1
                ->create([
                    'name' => "Cliente da Silva n,º $value",
                    'email' => "client$value@user.com"
                    ])->each(function($user) use($clients){  // para cada utilizador criado associar um cliente
                        $client = $clients->random(); // vai buscar um client(tenant) aliatório para associas
                        $user->client()->associate($client)
                        ->save(); // associa esse cliente que foi atibuido na linah de cima
                    });
        }
    }
}
