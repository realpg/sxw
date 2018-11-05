<?php

namespace App\Console;

use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\FJMYDataManager;
use App\Components\FJMYManager;
use App\Components\MemberManager;
use App\Components\SellDataManager;
use App\Components\SellManager;
use App\Components\XCXLogManager;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\VIPController;
use App\Http\Controllers\We7Controller;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
			Log::info('生成日榜：'.now());
		})->everyThirtyMinutes()->hourlyAt(30);
		
		$schedule->call(function () {
			//每分钟同步积分
			$m = (int)date('i');
			if ($m % 2)
				We7Controller::syncCreditRecordFromWe7();
			else
				We7Controller::syncCreditToWe7();
			Log::info('同步积分：'.now());
		})->everyMinute();
		
		$schedule->call(function () {
			//每小时生成周排行榜
			RankingController::createDailyRanking(2);
			Log::info('生成周榜：'.now());
		})->hourlyAt(15);
		
		$schedule->call(function () {
			//每天生成月榜
			RankingController::createDailyRanking(3);
			RankingController::clear();
			Log::info('生成月榜：'.now());
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
					if ($sell->thumbs == '') {
						$sell->thumbs .= $sell->thumb;
						$sell->thumbs = $sell->thumbs ? ($sell->thumbs . ',' . $sell->thumb1) : $sell->thumbs;
						$sell->thumbs = $sell->thumbs ? ($sell->thumbs . ',' . $sell->thumb2) : $sell->thumbs;
						$sell->save();
					}
					
					$searchInfo = SellManager::createSearchInfo($sell);
					$searchInfo->save();
					
					$infodata = SellDataManager::getById($sell->itemid);
					InfoController::Info_Banword($sell, $infodata);
				}
			}
			$buys = BuyManager::getList();
			foreach ($buys as $buy) {
				$user = MemberManager::getByUsername($buy->username);
				if (!$user) {
					$buy->delete();
				} else {
					if ($buy->thumbs == '') {
						$buy->thumbs .= $buy->thumb;
						$buy->thumbs = $buy->thumbs ? ($buy->thumbs . ',' . $buy->thumb1) : $buy->thumbs;
						$buy->thumbs = $buy->thumbs ? ($buy->thumbs . ',' . $buy->thumb2) : $buy->thumbs;
						$buy->save();
					}
					$searchInfo = BuyManager::createSearchInfo($buy);
					$searchInfo->save();
					
					$infodata = BuyDataManager::getById($buy->itemid);
					InfoController::Info_Banword($buy, $infodata);
				}
			}
			Log::info('生成搜索信息：'.now());
		})->dailyAt('19:00');  //unix时间19点，即北京时间3点
		
		$schedule->call(function () {
			//每天校验VIP信息
			VIPController::check();
			Log::info('校验VIP信息：'.now());
		})->dailyAt('17:00');  //unix时间17点，即北京时间1点
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
