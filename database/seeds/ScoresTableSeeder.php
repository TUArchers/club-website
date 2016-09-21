<?php

use Illuminate\Database\Seeder;

/**
 * Scores Table Seeder
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
    public function run()
    {
        // Import data
        $data    = $this->getData();
        $scores  = new \Illuminate\Support\Collection($data->Scores);
        $rounds  = new \Illuminate\Support\Collection($data->Rounds);
        $archers = new \Illuminate\Support\Collection($data->Archers);

        // Grab the data and loop over it to add to the database
        foreach ($scores as $score) {

            // Get imported details on the round that was shot the archer that shot it, and the scorer
            $round  = $rounds->keyBy('id')->get($score->round);
            $archer = $archers->keyBy('id')->get($score->archer);
            $scorer = $archers->keyBy('id')->get($score->verifiedBy);

            // Ensure that both the round and the archer exist
            $round_id  = $this->getRoundId($round->title);
            $archer_id = $this->getUserId($archer->fullName);
            $scorer_id = $this->getUserId($scorer->fullName);

            // Add the score
            $this->makeScore(
                $score->dateShot,
                $round_id,
                $archer_id,
                $scorer_id,
                substr($score->bowClass, 0, 1),
                $score->total,
                $score->hits,
                $score->golds
            );
        }
        
    }

    // Internals ----
    /**
     * @return stdClass
     */
    private function getData()
    {
        return json_decode(
            file_get_contents(__DIR__ . '/existing_scores.json')
        )->dataroot;
    }

    /**
     * @param string $full_name
     *
     * @return int
     */
    private function getUserId($full_name)
    {
        $name       = explode(' ', $full_name);
        $first_name = array_shift($name);
        $last_name  = empty($name)? null: implode(' ', $name);

        $userId = DB::table('users')
            ->select('id')
            ->where([
                ['first_name', '=', $first_name],
                ['last_name', '=', $last_name]
            ])
            ->first();

        $userId = $userId? $userId->id: null;

        if(!$userId){
            $user_data = [
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'password_hash' => Hash::make(str_random(12)),
                'phone_number'  => '01642384461',
                'role_id'       => 4,
                'registered_at' => \Carbon\Carbon::now()
            ];
            $user_data['email_address'] = sprintf('%s.%s@tuarchers.org.uk', $user_data['first_name'], $user_data['last_name']);

            $userId = DB::table('users')->insertGetId($user_data);
        }

        return $userId;
    }

    /**
     * @param string $title
     *
     * @return int
     */
    private function getRoundId($title)
    {
        return DB::table('rounds')
            ->select('id')
            ->where('name', '=', $title)
            ->first()
            ->id;
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
    private function makeScore($shot_at, $round_id, $archer_id, $scorer_id, $bow_class, $total_score, $hit_count, $gold_count)
    {
        $shot_at   = \Carbon\Carbon::parse($shot_at);

        DB::table('scores')->insert(
            compact('shot_at', 'round_id', 'archer_id', 'scorer_id', 'bow_class', 'total_score', 'hit_count', 'gold_count')
        );
    }

}
