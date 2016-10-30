<?php
namespace TuaWebsite\Domain\Records;

use Illuminate\Database\Eloquent\Model;
use TuaWebsite\Domain\Identity\Organisation;

/**
 * Round
 *
 * @package TuaWebsite\Domain\Records
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class Round extends Model
{
    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'name',
        'organisation',
        'season',
        'total_targets',
        'total_shots',
        'max_score',
        'max_shot_score',
        'min_shot_score'
    ];
    protected $dates    = [
        'created_at',
        'updated_at'
    ];

    // Relationships ----
    //

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
     * @return Season
     */
    public function getSeasonAttribute()
    {
        return Season::find(
            $this->attributes['season']
        );
    }

    /**
     * @return bool
     */
    public function getIsMultiDistanceAttribute()
    {
        return $this->attributes['total_targets'] > 1;
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

    /**
     * @param Season|string $value
     */
    public function setSeasonAttribute($value)
    {
        if($value instanceof Season){
            $value = $value->id;
        }

        $this->attributes['season'] = $value;
    }
}
