<?php
namespace TuaWebsite\Domain\Records;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TuaWebsite\Domain\Identity\User;

/**
 * Score
 *
 * @package TuaWebsite\Model
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class Score extends Model
{
    // Settings ----
    public $timestamps = true;
    public $fillable   = [
        'round_id',
        'archer_id',
        'scorer_id',
        'bow_class',
        'hit_count',
        'gold_count',
        'total_score',
        'shot_at'
    ];
    protected $dates   = [
        'shot_at',
        'created_at',
        'updated_at'
    ];

    // Relationships ----
    /**
     * @return BelongsTo|User
     */
    public function archer()
    {
        return $this->belongsTo(User::class, 'archer_id', 'id', 'archer');
    }

    /**
     * @return BelongsTo|User
     */
    public function scorer()
    {
        return $this->belongsTo(User::class, 'scorer_id', 'id', 'scorer');
    }

    /**
     * @return BelongsTo|Round
     */
    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}
