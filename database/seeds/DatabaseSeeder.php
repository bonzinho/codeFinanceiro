<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(ClientsTableSeeder::class); // cria os clientes para que ao criar os utilizadores já existam clientes para associar
        $this->call(UsersTableSeeder::class);
        $this->call(BankAccountsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

    }

}
