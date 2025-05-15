<?php

namespace App\Services;

use App\Models\Video;

class VideoService extends BaseService
{
    public function __construct(Video $video)
    {
        parent::__construct($video);
    }
} 