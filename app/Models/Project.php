<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'IdProject',
        'client_id',
        'name',
        'description',
        'preventive',
        'is_available',
    ];

    protected $attributes = [
        'preventive' => 0.00,
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function createDate()
    {
        return mb_convert_case(
            Carbon::parse($this->created_at)
                ->locale('it')
                ->translatedFormat('d F Y'),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }
}
