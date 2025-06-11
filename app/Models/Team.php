<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'admin_id',
        'name',
        'is_available',
    ];

    //relazioni
    // Relazione con tutti gli utenti del team (sia PM che developers)
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'developer_id');
    }

    // Relazione con il Project Manager (uno per team)
    public function pms()
    {
        return $this->users()->where('type', 'pm');
    }

    // Relazione con i Developers (molti per team)
    public function developers()
    {
        return $this->users()->where('type', 'developer');
    }
}
