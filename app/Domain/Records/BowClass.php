<?php
namespace TuaWebsite\Domain\Records;

use Illuminate\Database\Eloquent\Collection;

/**
 * Bow Class
 *
 * @package TuaWebsite\Domain\Records
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class BowClass
{
    // Constants ----
    const COMPOUND    = 'C';
    const RECURVE     = 'R';
    const BAREBOW     = 'B';
    const LONGBOW     = 'L';
    const TRADITIONAL = 'T';

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
     * @return BowClass
     */
    public static function compound()
    {
        return new self(self::COMPOUND, 'Compound');
    }

    /**
     * @return BowClass
     */
    public static function recurve()
    {
        return new self(self::RECURVE, 'Recurve');
    }

    /**
     * @return BowClass
     */
    public static function barebow()
    {
        return new self(self::BAREBOW, 'Barebow');
    }

    /**
     * @return BowClass
     */
    public static function longbow()
    {
        return new self(self::LONGBOW, 'Longbow');
    }

    /**
     * @return BowClass
     */
    public static function traditional()
    {
        return new self(self::TRADITIONAL, 'Traditional');
    }

    // Queries ----
    /**
     * @return Collection|BowClass[]
     */
    public static function all()
    {
        return new Collection([
            self::compound(),
            self::recurve(),
            self::barebow(),
            self::longbow(),
            self::traditional()
        ]);
    }

    /**
     * @param string $id
     *
     * @return BowClass
     */
    public static function find($id)
    {
        return self::all()->keyBy('id')->get($id);
    }
}