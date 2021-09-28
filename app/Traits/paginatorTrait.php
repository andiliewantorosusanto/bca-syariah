<?php

namespace App\Traits;

trait paginatorTrait
{

    /**
     * @return response
     */
    public function convertPaginator($paginator)
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
            'data'      => $data,
            'meta'      => $meta
        ];
    }
}
