<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    use \codeFin\Repositories\GetClientsTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();

        // factory das categorias pais
        factory(\codeFin\Models\Category::class, 30)
            ->make()  // make em vez de create para poder ser atribuido o id do cliente
            ->each(function($category) use($clients){
                $client = $clients->random();
                $category->client_id = $client->id;
                $category->save();
            });

        $categoriesRoot = $this->getCategoriesRoot();

        foreach ($categoriesRoot as $root){
            factory(\codeFin\Models\Category::class, 3)
                ->make()  // make em vez de create para poder ser atribuido o id do cliente
                ->each(function($child) use($root){
                    $child->client_id = $root->client_id; // para manter o mesmo cliente e multitanacy nao ter erros
                    $child->save(); // salva a categoria filha
                    $child->parent()->associate($root); // a nossa cat filho vai ter como pai uma cat root
                    $child->save(); // salvamos novamente
                });
        }
    }

    private function getCategoriesRoot(){
        /** @var \codeFin\Repositories\CategoryRepository $repository */
        $repository = app(\codeFin\Repositories\CategoryRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
