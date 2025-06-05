<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoce extends Model
{
    protected $fillable = [
        'IdInvoice',
        'admin_id',
        'client_id',
        'project_id',
        'name',
        'client_name',
        'preventive',
        'pdf_path',
        'description',
        'is_available',
    ];

    protected $attributes = [
        'preventive' => 0.00,
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
 
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
   
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
