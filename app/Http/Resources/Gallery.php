<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Gallery extends JsonResource
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

        return[
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'desc' => $this->description,
            'status' => $status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
