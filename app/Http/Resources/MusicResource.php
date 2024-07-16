<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MusicResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'author' => $this->author,
      'song' => $this->song,
      'image' => $this->image ? Storage::url($this->image) : null,
      'isInUserLibrary' => $this->isInUserLibrary ?? false,
    ];
  }

  /**
   * Get additional data that should be returned with the resource array.
   *
   * @return array<string, mixed>
   */
  public function with(Request $request): array {
    return [
      'status' => 200
    ];
  }
}
