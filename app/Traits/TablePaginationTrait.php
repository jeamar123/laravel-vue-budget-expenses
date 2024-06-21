<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait TablePaginationTrait
{
    /**
     * Paginate a collection or query result and return paginated data with metadata.
     *
     * @param  \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder  $items
     * @param  int  $perPage
     * @param  string  $resourceClass
     * @param  array  $headers
     * @param  boolean  $paginate
     * @return array
     */
    public function paginateTableWithMeta($items, $perPage, $resourceClass, $headers = [], $paginate = false)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginator = $this->createLengthAwarePaginator($items, $perPage, $currentPage);

        $data = $this->transformCollection($paginator->items(), $resourceClass);

        if($paginate === 'true' || $paginate === true){
        // if($paginate){
            return [
                'data' => $data,
                'meta' => [
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    // 'next_page_url' => $paginator->nextPageUrl(),
                    // 'prev_page_url' => $paginator->previousPageUrl(),
                    // Add more metadata as needed
                ],
                'headers' => $headers
            ];  
        }else{
            return [
                'headers' => $headers,
                'data' => $data
            ];
        }

        
    }
    
    /**
     * Transform a collection using the specified resource class.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  string  $resourceClass
     * @return \Illuminate\Support\Collection
     */
    protected function transformCollection($items, $resourceClass)
    {
        return $resourceClass::collection($items);
    }

    /**
     * Create a LengthAwarePaginator instance.
     *
     * @param  \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder  $items
     * @param  int  $perPage
     * @param  int  $currentPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function createLengthAwarePaginator($items, $perPage, $currentPage)
    {
        return new LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
}