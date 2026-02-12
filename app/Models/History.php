<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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


    #[Scope]
    public function current_team(Builder $q){
        $q->where('team_id',filament()->getTenant()?->id);
    }
}
