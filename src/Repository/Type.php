<?php

namespace App\Repository;

class Type extends BaseRepository
{
  public function getIdByName(string $name): array
  {
    return $this->queryAndFetch("SELECT id FROM type WHERE name = ?",[$name]);
  }
    
  public function getNames(): array
  {
    return $this->queryAndFetch("SELECT name FROM type WHERE name != 'Basic' ");
  }

  public function getType(int $id_insurances)
  {
    return $this->queryAndFetchForOne("SELECT type.name FROM type INNER JOIN insurances ON type.id = insurances.id_type WHERE insurances.id LIKE ?",[$id_insurances]);
  }

  public function getMultiple(string $type)
  {
    return $this->queryAndFetchForOne("SELECT multiple, id FROM type WHERE name = ?",[$type]);
  }
}

?>