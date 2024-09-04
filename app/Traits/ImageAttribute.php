<?php

namespace App\Traits;

trait ImageAttribute
{
  public function getImageAttribute($value)
  {
    return $value ?: '404.png';
  }
}
