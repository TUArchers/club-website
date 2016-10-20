<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use TuaWebsite\Domain\Identity\Gender;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\BowClass;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;

/**
 * Historical Scores Table Seeder
 *
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class HistoricalScoresTableSeeder extends Seeder
{
    // Counters ---
    private $requestedRecords = 0;
    private $attemptedRecords = 0;
    private $completedRecords = 0;

    // Methods ----
    /**
     * Run the database seeds
     */
    public function run()
    {
        // Load data from source (JSON file)
        $scores                 = $this->loadScoreData();
        $this->requestedRecords = $scores->count();

        // Loop over scores
        foreach($scores as $score){

            // Check if the score has already been recorded
            if($this->scoreHasBeenRecorded($score->total, $score->hit_count, $score->gold_count, $score->bow_class, $score->date)){
                echo sprintf("\n%s: Score has already been recorded; Skipping.", $score->id);
                continue;
            }

            // Record the attempt
            $this->attemptedRecords ++;

            // Lookup the user
            try{
                $user = $this->findUser($score->archer_first_name, $score->archer_last_name);
            }
            catch(RuntimeException $ex){
                // Couldn't find the user, so register them
                $this->writeImportError($ex, $score->id, "%s: %s; Registering them instead.");

                try{
                    // Carry out the registration
                    $this->registerUser(
                        $score->archer_email,
                        $score->archer_first_name,
                        $score->archer_last_name,
                        $score->archer_tusc_id,
                        $score->archer_gender
                    );

                    // Query for them again
                    $user = $this->findUser($score->archer_first_name, $score->archer_last_name);
                }
                catch(Exception $ex){
                    $this->writeImportError($ex, $score->id);
                    continue;
                }
            }

            // Lookup the round
            try{
                $round = $this->findRound($score->round_name);
            }
            catch(RuntimeException $ex){
                $this->writeImportError($ex, $score->id);
                continue;
            }

            // Lookup the bow class
            try{
                $bow_class = $this->findBowClass($score->bow_class);
            }
            catch(RuntimeException $ex){
                $this->writeImportError($ex, $score->id);
                continue;
            }

            // Parse the score into a score and save it
            $this->storeScore(
                $score->date,
                $round->id,
                $user->id,
                $user->id,
                $bow_class->id,
                $score->total,
                $score->hit_count,
                $score->gold_count
            );

            // Record the completed record
            $this->completedRecords ++;
        }

        // All done, output a message to confirm
        echo sprintf(
            "\nScore import complete. \n\tRequested Records: %s \n\tAttempted Records: %s \n\tCompleted Records: %s",
            $this->requestedRecords,
            $this->attemptedRecords,
            $this->completedRecords
        );
    }

    // Internals ----
    /**
     * @param Exception $ex
     * @param int       $recordId
     * @param string    $message
     */
    private function writeImportError(Exception $ex, $recordId, $message = null)
    {
        $message = is_string($message)? $message : "%s: Import failed. Reason given: '%s'";

        echo sprintf("\n" . $message, $recordId, $ex->getMessage());
    }
    
    /**
     * @param string $file_name
     *
     * @return Collection
     */
    private function loadScoreData($file_name = 'historical_scores.json')
    {
        $scores_json = file_get_contents(__DIR__ . '/' . $file_name);
        $scores      = json_decode($scores_json);

        return new Collection($scores);
    }

    /**
     * @param int    $total_score
     * @param int    $hit_count
     * @param int    $gold_count
     * @param string $bow_class
     * @param string $shot_at
     *
     * @return bool
     */
    private function scoreHasBeenRecorded($total_score, $hit_count, $gold_count, $bow_class, $shot_at)
    {
        $score = Score::where([
            ['total_score', '=', $total_score],
            ['hit_count', '=', $hit_count],
            ['gold_count', '=', $gold_count],
            ['bow_class', '=', strtoupper(substr($bow_class, 0, 1))],
            ['shot_at', '=', Carbon::parse($shot_at)],
        ])->first();

        return !empty($score);
    }

    /**
     * @param string $first_name
     * @param string $last_name
     *
     * @return User
     */
    private function findUser($first_name, $last_name)
    {
        $user = User::where([
            ['first_name', '=', $first_name],
            ['last_name', '=', $last_name]
        ])->first();

        if(!$user){
            throw new RuntimeException(sprintf('Could not find a user called %s %s', $first_name, $last_name));
        }

        return $user;
    }

    /**
     * @param $email
     * @param $first_name
     * @param $last_name
     * @param null $tusc_id
     * @param null $gender
     */
    private function registerUser($email, $first_name, $last_name, $tusc_id = null, $gender = null)
    {
        // Prepare data
        $tusc_id       = $tusc_id? strtoupper($tusc_id): null;
        $gender        = $gender? Gender::find(strtoupper(substr($gender, 0, 1)))->id: Gender::unspecified()->id;
        $password_hash = Hash::make(Str::random());
        $role_id       = 4;
        $phone         = '01642384461';
        $registered_at = Carbon::now();

        // Register user
        DB::table('users')->insert(
            compact('email', 'password_hash', 'first_name', 'last_name', 'tusc_id', 'gender', 'registered_at', 'role_id', 'phone')
        );
    }

    /**
     * @param string $name
     *
     * @return Round
     */
    private function findRound($name)
    {
        $round = Round::where([
            ['name', '=', $name]
        ])->first();

        if(!$round){
            throw new RuntimeException(sprintf('Could not find a round called %s', $name));
        }

        return $round;
    }

    /**
     * @param string $name
     *
     * @return BowClass
     */
    private function findBowClass($name)
    {
        $bow_class = BowClass::find(
            strtoupper(substr($name, 0, 1))
        );

        if(!$bow_class){
            throw new RuntimeException(sprintf('Could not find a bow class called %s', $name));
        }

        return $bow_class;
    }

    /**
     * @param string $shot_at
     * @param int    $round_id
     * @param int    $archer_id
     * @param int    $scorer_id
     * @param string $bow_class
     * @param int    $total_score
     * @param int    $hit_count
     * @param int    $gold_count
     */
    private function storeScore($shot_at, $round_id, $archer_id, $scorer_id, $bow_class, $total_score, $hit_count, $gold_count)
    {
        // Convert dates
        $shot_at = Carbon::parse($shot_at);

        // Store the score
        DB::table('scores')->insert(
            compact('shot_at', 'round_id', 'archer_id', 'scorer_id', 'bow_class', 'total_score', 'hit_count', 'gold_count')
        );
    }
}
