<?php

namespace App\Console;
use App\Mail\Breakdown;
use App\User;
use Mail;
use DB;
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
        $schedule->call(function () {
            $users=User::where('email_frequency','Every Minute')->get();
            foreach($users as $user)
            {   
                $email=$user->email;
                Mail::to($email)->send(new Breakdown($user));
            }
        })->everyMinute();

        $schedule->call(function () {
            $users=User::where('email_frequency','Daily')->get();
            foreach($users as $user)
            {   
                $email=$user->email;
                Mail::to($email)->send(new Breakdown($user));
            }
        })->daily();

        $schedule->call(function () {
            $users=User::where('email_frequency','Weekly')->get();
            foreach($users as $user)
            {   
                $email=$user->email;
                Mail::to($email)->send(new Breakdown($user));
            }
        })->weekly();

        $schedule->call(function () {
            $users=User::where('email_frequency','Monthly')->get();
            foreach($users as $user)
            {   
                $email=$user->email;
                Mail::to($email)->send(new Breakdown($user));
            }
        })->monthly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
