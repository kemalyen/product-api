<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
            ],
            'relationships' => [
                'roles' => [
                    'data' => [
                        'type' => 'roles',
                        'name' => (isset($this->roles[0]) ? $this->roles[0]->name : null)
                    ], 
                ]
            ],
            'includes' => new AccountResource($this->whenLoaded('account')),
        ];
    }
}
