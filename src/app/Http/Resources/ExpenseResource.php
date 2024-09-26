<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Casts can be added here
        $data = [
            "id"=> $this->id,
            "description"=> $this->description,
            "amount"=> $this->amount,
            "date"=> $this->date,
            "user_id"=> $this->user_id,
            "user_name" => $this->user['name'] ?? null,
            "date_formated_DMY" => Carbon::make($this->date)->format('d/m/Y'),
        ];
        
        return $data;
    }
}
