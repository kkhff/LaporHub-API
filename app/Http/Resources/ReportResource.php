<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => url('storage/reports/' . $this->image),
            'date_report' => $this->created_at->format('d M Y H:i'),
            'name' => $this->user->name,
            'category' => $this->category->name,
            'status' => $this->status,
        ];
    }
}
