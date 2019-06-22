<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Products extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->status == 1){
            $status = [
                'name' => 'Active',
                'value' => '1',
            ];
        }
        else if($this->status == 0){
            $status = [
                'name' => 'Inactive',
                'value' => '0',
            ];
        }

        if($this->featured == 1){
            $featured = [
                'name' => 'Yes',
                'value' => '1',
            ];
        }
        else if($this->featured == 0){
            $featured = [
                'name' => 'No',
                'value' => '0',
            ];
        }

        $category = [
            'id' => $this->category_id,
            'name' => $this->category,
        ];

        return[
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'desc' => $this->description,
            'category' => $category,
            'srp' => $this->srp,
            'stock' => $this->stock,
            'critical' => $this->critical,
            'status' => $status,
            'stock' => $this->stock,
            'featured' => $featured,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
