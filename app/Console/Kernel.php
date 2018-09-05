<?php

namespace App\Console;

use App\Components\BuyManager;
use App\Components\FJMYManager;
use App\Components\MemberManager;
use App\Components\SellManager;
use App\Components\XCXLogManager;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\VIPController;
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

//		$schedule->call(function () {
//			//每分钟生成日榜
//			RankingController::createDailyRanking(1);
//		})->everyMinute();
		
		$schedule->call(function () {
			//每小时生成周排行榜
			RankingController::createDailyRanking(2);
		})->hourlyAt(15);
		
		$schedule->call(function () {
			//每天生成月榜
			RankingController::createDailyRanking(3);
			RankingController::clear();
		})->dailyAt('19:00');  //unix时间19点，即北京时间3点
		
		
		$schedule->call(function () {
			//每天清理信息
			//每天生成搜索信息
			$sells = SellManager::getList();
			foreach ($sells as $sell) {
				$user = MemberManager::getByUsername($sell->username);
				if (!$user) {
					$sell->delete();
				} else {
					$searchInfo = SellManager::createSearchInfo($sell);
					$searchInfo->save();
				}
			}
			$buys = BuyManager::getList();
			foreach ($buys as $buy) {
				$user = MemberManager::getByUsername($buy->username);
				if (!$user) {
					$buy->delete();
				} else {
					$searchInfo = BuyManager::createSearchInfo($buy);
					$searchInfo->save();
				}
			}
			$fjmys = FJMYManager::getList();
			foreach ($fjmys as $fjmy) {
				$user = MemberManager::getByUsername($fjmy->username);
				if (!$user) {
					$fjmy->delete();
				} else {
					$searchInfo = FJMYManager::createSearchInfo($fjmy);
					$searchInfo->save();
				}
			}
		})->dailyAt('19:00');  //unix时间19点，即北京时间3点
		
		$schedule->call(function () {
			//每天校验VIP信息
			VIPController::check();
		})->dailyAt('17:00');  //unix时间17点，即北京时间1点

//		$schedule->call(function () {
//			//每周一清理log
//			XCXLogManager::clearLog();
//		})->weekly()->mondays()->at('18:00');
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
