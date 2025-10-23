<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'job_question_id',
        'answer',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function question()
    {
        return $this->belongsTo(JobQuestion::class, 'job_question_id');
    }
}
