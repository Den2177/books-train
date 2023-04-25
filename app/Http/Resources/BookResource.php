<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sum = 0;

        foreach ($this->scores as $score) {
            $sum += $score->value;
        }
        $averageRating = 0;

        if (count($this->scores) !== 0) {
            $averageRating = round($sum / count($this->scores));
        } else {
            $averageRating = 0;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'text' => $this->text,
            'score' => $averageRating,
            'author' => $this->author,
            'genres' => $this->genres,
            'created_at' => $this->created_at,
        ];
    }
}
