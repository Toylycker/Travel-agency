<?php

namespace App\Services;

use App\Models\Post;

class PostService extends BaseService
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }
} 