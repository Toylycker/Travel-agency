<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PlaceResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;

class DayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'day_number'=>$this->day_number,
            'title'=>$this->title,
            'body'=>$this->body,
            'places'=>$this->places->makeHidden('pivot')->map(function($element){return $element->id;}),
            'hotels'=>$this->hotels->makeHidden('pivot')->map(function($element){return $element->id;}),
        ];
    }
}
