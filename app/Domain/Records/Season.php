<?php
namespace TuaWebsite\Domain\Records;

use Illuminate\Support\Collection;

/**
 * Season
 *
 * @package TuaWebsite\Domain\Records
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class Season
{
    // Constants ----
    const INDOOR  = 'I';
    const OUTDOOR = 'O';

    // Properties ----
    /** @var string */
    public $id;
    /** @var string */
    public $name;

    // Setup ----
    private function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return Season
     */
    public static function indoor()
    {
        return new self(self::INDOOR, 'Indoor');
    }

    /**
     * @return Season
     */
    public static function outdoor()
    {
        return new self(self::OUTDOOR, 'Outdoor');
    }

    // Queries ----
    /**
     * @return string[]
     */
    public static function keys()
    {
        return [
            self::INDOOR,
            self::OUTDOOR
        ];
    }

    /**
     * @return Collection|Season[]
     */
    public static function all()
    {
        return new Collection([
            self::indoor(),
            self::outdoor()
        ]);
    }

    /**
     * @param string $id
     *
     * @return Season
     */
    public static function find($id)
    {
        return self::all()->keyBy('id')->get($id);
    }
}