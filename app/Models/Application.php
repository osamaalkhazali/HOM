<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_id',
        'user_id',
        'cv_path',
        'cover_letter',
        'status',
    ];

    /**
     * Get the job that owns the application.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user that owns the application.
     */
    public function user()
    {
    return $this->belongsTo(User::class);
  }

  public function questionAnswers()
  {
    return $this->hasMany(ApplicationQuestionAnswer::class);
  }

  public function documents()
  {
    return $this->hasMany(ApplicationDocument::class);
  }
}
