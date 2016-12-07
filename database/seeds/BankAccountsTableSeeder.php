<?php

use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /** @var \codeFin\Repositories\BankRepository $repository */
        $repository = app(\codeFin\Repositories\BankRepository::class);
        $banks = $repository->all();
        $max = 15;
        $bankAccountId = rand(1, $max);

        factory(\codeFin\Models\BankAccount::class, $max)
           ->make()// gera uma instancia do modelo mas nao salva no db
           ->each(function($bankAccount) use ($banks, $bankAccountId){
                $bank = $banks->random();
                $bankAccount->bank_id = $bank->id;

                $bankAccount->save();

                if ($bankAccountId == $bankAccount->id){
                    $bankAccount->default = 1;
                    $bankAccount->save();
                }

           });



    }
}
