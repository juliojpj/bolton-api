<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotaFiscalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => [
                'code' => 'code-value',
                'message' => 'messa-value'
            ],
            'data' => $this->collection,
            'page' => [
                'next' => 'next-value',
            ],
        ];
    }
}
