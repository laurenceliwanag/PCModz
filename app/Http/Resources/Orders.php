<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Orders extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->status == 2){
            $status = [
                'name' => 'Sales',
                'value' => '2',
            ];
        }
        else if($this->status == 1){
            $status = [
                'name' => 'Approved',
                'value' => '1',
            ];
        }
        else if($this->status == 0){
            $status = [
                'name' => 'Pending',
                'value' => '0',
            ];
        }

        
        $user = [     
            'user_id' => $this->user_id,
            'user_name' => $this->user_name
        ];

        $product = [     
            'product_id' => $this->product_id,
            'product_name' => $this->product_name
        ];
       

        return[
            'id' => $this->id,
            'invoice' => $this->invoice,
            'incharge_id' => $this->incharge_id,
            'user' => $user,
            'product' => $product,
            'order_quantity' => $this->order_quantity,
            'srp' => $this->total / $this->order_quantity,
            'total' => $this->total,
            'status' => $status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
