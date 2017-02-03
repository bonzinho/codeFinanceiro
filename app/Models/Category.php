<?php

namespace codeFin\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Category extends Model implements Transformable
{
    use TransformableTrait;
    use BelongsToTenants;
    use NodeTrait; // faz com que este modelo seja um nó

    protected $fillable = ['name'];
    public static $enableTenant = true;

    public function newQuery()
    {
        $builder = $this->newQueryWithoutScopes(); // cria um novo query bulider sem escopo sem interferencia externa (traits)

        foreach ($this->getGlobalScopes() as $identifier => $scope) {  // pega os escopos globais do modelo para aplicar no query builder
            if((static::$enableTenant && $identifier == 'client_id') || $identifier != 'client_id'){  // client_id foi definido no nosso multitanacy
                $builder->withGlobalScope($identifier, $scope);
            }
        }

        return $builder;
    }

}
