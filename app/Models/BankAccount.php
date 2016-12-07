<?php

namespace codeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BankAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'agency',
        'account',
        'bank_id'
    ];

    // relacionamento de muitos para um
    public function bank(){
        return $this->belongsTo(Bank::class);
    }

}
