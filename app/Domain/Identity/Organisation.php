<?php
namespace TuaWebsite\Domain\Identity;

use Illuminate\Support\Collection;

/**
 * Organisation
 *
 * @package TuaWebsite\Domain\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class Organisation
{
    // Constants ----
    const TEESSIDE_UNIVERSITY            = 'TU';
    const TEESSIDE_UNIVERSITY_SU         = 'TUSU';
    const TEESSIDE_UNIVERSITY_ARCHERS    = 'TUA';
    const WORLD_ARCHERY                  = 'WA';
    const ARCHERY_GB                     = 'AGB';
    const NATIONAL_FIELD_ARCHERY_SOCIETY = 'NFAS';

    // Properties ----
    public $id;
    public $name;

    // Setup ----
    private function __construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return Organisation
     */
    public static function teessideUniversity()
    {
        return new self(self::TEESSIDE_UNIVERSITY, 'Teesside University');
    }

    /**
     * @return Organisation
     */
    public static function teessideUniversityStudentsUnion()
    {
        return new self(self::TEESSIDE_UNIVERSITY_SU, 'Teesside University Student\'s Union');
    }

    /**
     * @return Organisation
     */
    public static function teessideUniversityArchers()
    {
        return new self(self::TEESSIDE_UNIVERSITY_ARCHERS, 'Teesside University Archers');
    }

    /**
     * @return Organisation
     */
    public static function worldArchery()
    {
        return new self(self::WORLD_ARCHERY, 'World Archery');
    }

    /**
     * @return Organisation
     */
    public static function archeryGB()
    {
        return new self(self::ARCHERY_GB, 'Archery GB');
    }

    /**
     * @return Organisation
     */
    public static function nationalFieldArcherySociety()
    {
        return new self(self::NATIONAL_FIELD_ARCHERY_SOCIETY, 'National Field Archery Society');
    }

    // Queries ----
    /**
     * @return string[]
     */
    public static function keys()
    {
        return [
            self::TEESSIDE_UNIVERSITY,
            self::TEESSIDE_UNIVERSITY_SU,
            self::TEESSIDE_UNIVERSITY_ARCHERS,
            self::WORLD_ARCHERY,
            self::ARCHERY_GB,
            self::NATIONAL_FIELD_ARCHERY_SOCIETY
        ];
    }

    /**
     * @return Collection|Organisation[]
     */
    public static function all()
    {
        return new Collection([
            self::teessideUniversity(),
            self::teessideUniversityStudentsUnion(),
            self::teessideUniversityArchers(),
            self::worldArchery(),
            self::archeryGB(),
            self::nationalFieldArcherySociety()
        ]);
    }

    /**
     * @param string $id
     *
     * @return Organisation
     */
    public static function find($id)
    {
        return self::all()->keyBy('id')->get($id);
    }
}