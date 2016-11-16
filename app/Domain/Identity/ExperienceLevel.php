<?php
namespace TuaWebsite\Domain\Identity;

use Illuminate\Support\Collection;

/**
 * ExperienceLevel
 *
 * @package TuaWebsite\Domain\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class ExperienceLevel
{
    // Constants ----
    const BEGINNER    = 'B';
    const NOVICE      = 'N';
    const EXPERIENCED = 'E';

    // Properties ----
    public $id;
    public $name;

    // Setup ----
    private function __construct($id, $name)
    {
        //TODO: Introduce this as a simple Enumerable pattern (until it gets natively supported)?
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return ExperienceLevel
     */
    public static function beginner()
    {
        return new self(self::BEGINNER, 'Beginner');
    }

    /**
     * @return ExperienceLevel
     */
    public static function novice()
    {
        return new self(self::NOVICE, 'Novice');
    }

    /**
     * @return ExperienceLevel
     */
    public static function experienced()
    {
        return new self(self::EXPERIENCED, 'Experienced');
    }

    // Queries ----
    /**
     * @return Collection|ExperienceLevel[]
     */
    public static function all()
    {
        return new Collection([
            self::beginner(),
            self::novice(),
            self::experienced()
        ]);
    }

    /**
     * @param string $id
     *
     * @return ExperienceLevel
     */
    public static function find($id)
    {
        return self::all()
            ->keyBy('id')
            ->get($id);
    }

    /**
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param ExperienceLevel $experienceLevel
     *
     * @return bool
     */
    public function is(ExperienceLevel $experienceLevel)
    {
        return $this->id == $experienceLevel->id;
    }
}