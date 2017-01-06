<?php

namespace codeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];

    //esta class é como se fosse um tenant (client->usuario  | um para muitos) um cliente tem varios usuarios um user tem um tenant
    public function user(){
        return $this->hasMany(User::class);
    }

}
