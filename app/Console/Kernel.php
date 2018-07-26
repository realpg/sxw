<?php

namespace App\Console;

use App\Components\XCXLogManager;
use App\Http\Controllers\RankingController;
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
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function () {
			//每30分钟生成日榜
			RankingController::createDailyRanking(1);
		})->everyThirtyMinutes()->hourlyAt(30);
		$schedule->call(function () {
			//每小时生成周排行榜
			RankingController::createDailyRanking(2);
		})->hourlyAt(15);
		$schedule->call(function () {
			//每天生成月榜
			RankingController::createDailyRanking(3);
		})->dailyAt('3:00');
		$schedule->call(function () {
			//每周一清理log
			XCXLogManager::clearLog();
		})->weekly()->mondays()->at('02:00');
	}
	
	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');
		
		require base_path('routes/console.php');
	}
}
