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
        $data = [
            "id" => $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
        ];

        // Add token if exists
        if (isset($this->token)) {
            $data["token"] = $this->token;
            $data['exp'] = $this->exp;
        }

        return $data;
    }
}
