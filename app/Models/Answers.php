<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Model\Questions;

class Answers extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'answer',
        'status',
    ];

    /**
     * Get the questions that owns the Answers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questions(): BelongsTo
    {
        return $this->belongsTo(Questions::class);
    }
}
