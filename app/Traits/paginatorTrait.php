<?php

namespace App\Traits;

trait paginatorTrait
{

    /**
     * @return response
     */
    public function convertPaginator($paginator,$varname = "data")
    {
        $data = $paginator->items();

        $meta = [
            'current_page'  => $paginator->currentPage(),
            'last_page'     => $paginator->lastPage(),
            'per_page'      => $paginator->perPage(),
            'from'          => $paginator->firstItem(),
            'to'            => $paginator->lastItem(),
            'total'         => $paginator->total()
        ];

        return [
            $varname    => $data,
            'meta'      => $meta
        ];
    }
}
