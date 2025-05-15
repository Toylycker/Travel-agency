<?php

namespace App\Services;

use App\Models\Note;

class NoteService extends BaseService
{
    public function __construct(Note $note)
    {
        parent::__construct($note);
    }
} 