<?php

namespace App\Console;

use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {
            $words = [
                'aberration' => 'a state or condition markedly different from the norm',
                'convivial' => 'occupied with or fond of the pleasures of good company',
                'diaphanous' => 'so thin as to transmit light',
                'elegy' => 'a mournful poem; a lament for the dead',
                'ostensible' => 'appearing as such but not necessarily so'
            ];
            $users = User::all();
            foreach ($users as $user) {
                $key = array_rand($words);
                $value = $words[$key];

                \Mail::raw("{$key} -> {$value}", function ($mail) use ($user) {
                    $mail->from('mail@idstack.net');
                    $mail->to($user->email)
                        ->subject('Word of the Day');
                });
                sleep(5);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
