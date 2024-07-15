<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,            
            'visibility' => $this->visibility,            
            'main_picture' => $this->main_picture,            
            'colors' => is_array($this->colors) ? $this->colors : json_decode($this->colors,true),            
                       
        ];
    }
}
