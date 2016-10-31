<?php
namespace TuaWebsite\Domain\Identity;

use Illuminate\Support\Collection;

/**
 * Gender
 *
 * @package TuaWebsite\Domain\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class Gender
{
    // Constants ----
    const UNSPECIFIED = 'U';
    const MALE        = 'M';
    const FEMALE      = 'F';
    const OTHER       = 'O';

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
     * @return Gender
     */
    public static function unspecified()
    {
        return new self(self::UNSPECIFIED, 'Unspecified');
    }

    /**
     * @return Gender
     */
    public static function male()
    {
        return new self(self::MALE, 'Male');
    }

    /**
     * @return Gender
     */
    public static function female()
    {
        return new self(self::FEMALE, 'Female');
    }

    /**
     * @return Gender
     */
    public static function other()
    {
        return new self(self::OTHER, 'Other');
    }

    // Queries ----
    /**
     * @return Collection|Gender[]
     */
    public static function all()
    {
        return new Collection([
            self::unspecified(),
            self::male(),
            self::female(),
            self::other()
        ]);
    }

    /**
     * @param string $id
     *
     * @return Gender
     */
    public static function find($id)
    {
        return self::all()->keyBy('id')->get($id);
    }
}