<?php

namespace App\Repository;

class Type extends BaseRepository{

    public function searchId(string $name): array{

        return $this->queryAndFetch("SELECT id from type where name ="."'".$name."'");
    }
}

?>