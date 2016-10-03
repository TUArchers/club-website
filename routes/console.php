<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//});

Artisan::command('send:membership-info', function(){

    $this->info('Sending membership info...');

    // Get the user(s)
    $users = \TuaWebsite\Domain\Identity\User::where('registered_at', '>=', \Carbon\Carbon::createFromDate(2016, 9, 27))->get();

    foreach($users as $user){
        // Prep the mail
        $mail = new \TuaWebsite\Mail\MembershipInformation($user);
        $mail->subject('Ready to become an archer?');

        // Send (via queue)
        Mail::to($user)->queue($mail);
    }

    $this->info('Done');
});