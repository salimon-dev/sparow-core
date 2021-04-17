<?php

namespace App\Traits;


trait Paginate
{
    public function paginate()
    {
        $pageSize = request("pageSize", 15);
        return parent::paginate($pageSize);
    }
}
