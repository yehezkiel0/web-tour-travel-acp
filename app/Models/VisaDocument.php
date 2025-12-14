<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'visa_application_id',
        'document_name',
        'file_path',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'visa_application_id');
    }
}
