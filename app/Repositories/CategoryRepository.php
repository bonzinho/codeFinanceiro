<?php

namespace codeFin\Repositories;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoryRepository
 * @package namespace codeFin\Repositories;
 */
interface CategoryRepository extends RepositoryInterface, RepositoryCriteriaInterface // adicionamos RepositoryCriteriaInterface para que seja usado o criteria criado de categorias
{
    //
}
