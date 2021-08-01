<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Modules\API\Console\StartGetOrdersCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        StartGetOrdersCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command($this->getQueueCommand())
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command(StartGetOrdersCommand::class)
            ->everyMinute()
            ->withoutOverlapping();

    }

    protected function getQueueCommand()
    {
        // build the queue command
        $params = implode(' ',[
            '--stop-when-empty',
            '--tries=5',
            '--sleep=5',
        ]);
        return sprintf('queue:work %s', $params);
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
