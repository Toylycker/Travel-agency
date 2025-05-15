<?php

namespace App\Services;

use App\Models\Image;

class ImageService extends BaseService
{
    public function __construct(Image $image)
    {
        parent::__construct($image);
    }
} 