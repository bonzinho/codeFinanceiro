<?php

namespace codeFin\Http\Middleware;

use Closure;

class AddClientTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->is('api/*')){  // se a nossa requisição for da api
            $user = \Auth::guard('api')->user(); // acessar ao guardiao do api para pegar o user
            if($user){ // se exitir o utilizador, pode não haver se não estiver autenticado
                $client = $user->client;  // atribui o cliente relacionado com o utilizador à variavel $user
                \Landlord::addTenant($client);  // ou \Landlord::addTenant('client_id', $client->id);  ### Regista o o nosso observador no modelo, qualquer consulta a persistencia ele verifica o id do cliente
            }
        }
        return $next($request);
    }
}
