<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'action' => $this->data['action'],
            'message' => $this->data['message'],
            'date_notification' => $this->created_at->format('d M Y H:i'),
            'read_at' => $this->read_at !== null,
        ];
    }
}
