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
    // Constants ----
    const S_IMPERIAL       = '9, 7, 5, 3, 1';
    const S_METRIC_FULL    = '10, 9, 8, 7, 6, 5, 4, 3, 2, 1';
    const S_METRIC_HALF    = '10, 9, 8, 7, 6';
    const S_WORCESTER_FULL = '5, 4, 3, 2, 1';
    const S_WORCESTER_HALF = '5, 4';

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

    /**
     * @return string
     */
    public function getScoringSystemAttribute()
    {
        // TODO: This need not be derived; It can be stored as an enumerable on the round record. (Although that does not take multi-system rounds into account)
        $max_shotScore = $this->attributes['max_shot_score'];
        $min_shotScore = $this->attributes['min_shot_score'];

        switch($max_shotScore){
            case 10:
                return 6 == $min_shotScore? self::S_METRIC_HALF: self::S_METRIC_FULL;
            case 9:
                return self::S_IMPERIAL;
            case 5:
                return 4 == $min_shotScore? self::S_WORCESTER_HALF: self::S_WORCESTER_FULL;
            default:
                return self::S_METRIC_FULL;
        }
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

    // Queries ----
    /**
     * Get an array of available scoring systems
     *
     * TODO: Move this to a new model
     *
     * @return array
     */
    public static function scoringSystems()
    {
        $systems = [
            'I'  => 'Imperial (' . self::S_IMPERIAL . ')',
            'M'  => 'Metric (' . self::S_METRIC_FULL . ')',
            'MH' => 'Half Metric (' . self::S_METRIC_HALF .  ')',
            'W'  => 'Worcester (' . self::S_WORCESTER_FULL . ')',
            'WH' => 'Half Worcester (' . self::S_WORCESTER_HALF . ')'
        ];

        return array_map(function($id, $name){
            $obj = new \stdClass();

            $obj->id = $id;
            $obj->name = $name;

            return $obj;
        }, array_keys($systems), $systems);
    }

    /**
     * Get a scoring system by ID
     *
     * TODO: Move this to a new model
     *
     * @param string $id
     *
     * @return string
     * @throws \Exception
     */
    public static function scoringSystem($id)
    {
        switch ($id){
            case 'I':
                return self::S_IMPERIAL;
            case 'M':
                return self::S_METRIC_FULL;
            case 'MH':
                return self::S_METRIC_HALF;
            case 'W':
                return self::S_WORCESTER_FULL;
            case 'WH':
                return self::S_WORCESTER_HALF;
            default:
                throw new \Exception("Unknown scoring system '${id}'");
        }
    }

    /**
     * Get the score value achieved for the given ring number on this round's target face
     *
     * @param int $ring_number
     *
     * @return int
     */
    public function getScoreForRing($ring_number)
    {
        $scoring_system = explode(', ', $this->scoring_system);

        return $scoring_system[$ring_number-1];
    }
}
