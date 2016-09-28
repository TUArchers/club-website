<?php

namespace TuaWebsite\Domain\Identity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Demographic
 *
 * @package TuaWebsite\Domain\Identity
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class Demographic extends Model
{
    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'user_id',
        'school',
        'subject',
        'qualification',
        'year'
    ];
    protected $dates    = [
        'created_at',
        'updated_at'
    ];

    // Relationships
    /**
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
