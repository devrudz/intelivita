<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\Answers;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'status',
        'time_limit',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get all of the Answers for the Questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answers::class, 'question_id', 'id');
    }
}
