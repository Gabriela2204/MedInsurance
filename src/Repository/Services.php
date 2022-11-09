<?php

namespace App\Repository;

class Services extends BaseRepository{

    public function searchId(string $name): array{

        return $this->queryAndFetch("SELECT id from services where name ="."'".$name."'");
    }

    public function searchPrice(string $name): array{

        return $this->queryAndFetch("SELECT price from services where name ="."'".$name."'");
    }

}

?>