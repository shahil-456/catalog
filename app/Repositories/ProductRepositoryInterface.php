<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function allByCatalog($catalogId);
}
