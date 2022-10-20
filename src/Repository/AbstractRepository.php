<?php
namespace App\Repository;
use App\Entity\Insurances as Insurances;

abstract class AbstractRepository {
 
    protected abstract function insert(Insurances $item);
    protected abstract function update(Insurances $item, $id);

}


?>