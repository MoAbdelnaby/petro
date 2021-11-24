<?php

namespace App\Console;

use App\Console\Commands\AreaDurationDailyCommand;
use App\Console\Commands\AreaDurationTotalCommand;
use App\Console\Commands\ExportModelsFilesCommand;
use App\Console\Commands\HandleCarprofileCommand;
use App\Console\Commands\SendWelcomeMessageCommand;
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
        AreaDurationTotalCommand::class,
        AreaDurationDailyCommand::class,
        ExportModelsFilesCommand::class,
        SendWelcomeMessageCommand::class,
        HandleCarprofileCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('area:duration')->daily()->timezone('Asia/Riyadh');
         $schedule->command('area:duration-daily')->daily()->timezone('Asia/Riyadh');
         $schedule->command('files:export')->everyFiveMinutes()->timezone('Asia/Riyadh');
         $schedule->command('welcome:send')->everyMinute()->timezone('Asia/Riyadh');
         $schedule->command('reminder:send')->daily()->timezone('Asia/Riyadh');
         $schedule->command('profile:handle')->dailyAt('01:00')->timezone('Asia/Riyadh');
         $schedule->command('carplate:images-handle')->dailyAt('01:00')->timezone('Asia/Riyadh');
//         $schedule->command('queue:work --tries=3')->everyMinute()->withoutOverlapping();
         /* azure-images-upload */
         $schedule->command('plate-images:upload')->everyMinute()->timezone('Asia/Riyadh');
         $schedule->command('place-images:upload')->everyMinute()->timezone('Asia/Riyadh');

         $schedule->command('branch-status-api')->everyMinute();
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
