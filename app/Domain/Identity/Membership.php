<?php
namespace TuaWebsite\Domain\Identity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Membership
 *
 * @package TuaWebsite\Domain\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 *
 * @property User         $user
 * @property Organisation $organisation
 * @property string       $number
 * @property string       $description
 * @property Carbon       $valid_from
 * @property Carbon       $expires_at
 * @property bool         $has_expired
 * @property Carbon       $created_at
 * @property Carbon       $updated_at
 */
class Membership extends Model
{
    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'user_id',
        'organisation',
        'number',
        'description',
        'valid_from',
        'expires_at',
    ];
    protected $dates    = [
        'valid_from',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    // Accessors ----
    /**
     * @return Organisation
     */
    public function getOrganisationAttribute()
    {
        return Organisation::find(
            $this->attributes['organisation']
        );
    }

    /**
     * @return bool
     */
    public function getHasExpiredAttribute()
    {
        if(is_null($this->attributes['expires_at'])){
            return false;
        }

        $now         = Carbon::now();
        $expiry_date = Carbon::parse($this->attributes['expires_at']);

        return $now->gte($expiry_date);
    }

    /**
     * @return bool
     */
    public function getIsValidAttribute()
    {
        if(is_null($this->attributes['expires_at'])){
            return true;
        }

        $now           = Carbon::now();
        $validity_date = Carbon::parse($this->attributes['valid_from']);
        $expiry_date   = Carbon::parse($this->attributes['expires_at']);

        return $now->gte($validity_date) && $now->lt($expiry_date);
    }

    // Mutators ----
    /**
     * @param Organisation|string $value
     */
    public function setOrganisationAttribute($value)
    {
        if($value instanceof Organisation){
            $value = $value->id;
        }

        $this->attributes['organisation'] = $value;
    }
    
    // Scopes ----
    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->whereNull('expires_at')
            ->orWhere('expires_at', '>', Carbon::now());
    }
}
