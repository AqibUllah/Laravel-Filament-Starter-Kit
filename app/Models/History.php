<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $table = 'agent_conversation_messages';

    public $fillable = [
        'team_id',
        'user_id',
        'message',
        'response',
    ];
}
