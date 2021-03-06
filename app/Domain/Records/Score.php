<?php
namespace TuaWebsite\Domain\Records;

use Carbon\Carbon;
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
 *
 * @property int    $id
 * @property int    $round_id
 * @property Round  $round
 * @property int    $archer_id
 * @property User   $archer
 * @property int    $scorer_id
 * @property User   $scorer
 * @property string $bow_class
 * @property int    $hit_count
 * @property int    $gold_count
 * @property int    $total_score
 * @property Carbon $shot_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
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

    // Accessors ----
    /**
     * @return BowClass
     */
    public function getBowClassAttribute()
    {
        return BowClass::find($this->attributes['bow_class']);
    }
}
