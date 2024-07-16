<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model {
  use HasFactory, HasUuids;


  public $fillable = [
    'title',
    'author',
    'song',
    'image',
    'dir'
  ];


  public function user() {
    return $this->belongsToMany(User::class, 'libraries');
  }


  public function getIsInUserLibraryAttribute() {
    if (!auth('sanctum')->user()) return false;
    return $this->user->contains('id', auth('sanctum')->user()->id);
  }


  public function library() {
    return $this->belongsTo(Library::class);
  }
}
