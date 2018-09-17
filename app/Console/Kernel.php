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
			//每分钟同步积分
			We7Controller::syncCreditRecordFromWe7();
			We7Controller::syncCreditToWe7();
		})->everyMinute();
		
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
					if($sell->thumbs==''){
						$sell->thumbs.=$sell->thumb;
						$sell->thumbs=$sell->thumbs?($sell->thumbs.','.$sell->thumb1):$sell->thumbs;
						$sell->thumbs=$sell->thumbs?($sell->thumbs.','.$sell->thumb2):$sell->thumbs;
						$sell->save();
					}
					
					$searchInfo = SellManager::createSearchInfo($sell);
					$searchInfo->save();
					
					$infodata=SellDataManager::getById($sell->itemid);
					InfoController::Info_Banword($sell,$infodata);
				}
			}
			$buys = BuyManager::getList();
			foreach ($buys as $buy) {
				$user = MemberManager::getByUsername($buy->username);
				if (!$user) {
					$buy->delete();
				} else {
					if($buy->thumbs==''){
						$buy->thumbs.=$buy->thumb;
						$buy->thumbs=$buy->thumbs?($buy->thumbs.','.$buy->thumb1):$buy->thumbs;
						$buy->thumbs=$buy->thumbs?($buy->thumbs.','.$buy->thumb2):$buy->thumbs;
						$buy->save();
					}
					$searchInfo = BuyManager::createSearchInfo($buy);
					$searchInfo->save();
					
					$infodata=BuyDataManager::getById($buy->itemid);
					InfoController::Info_Banword($buy,$infodata);
				}
			}
			$fjmys = FJMYManager::getList();
			foreach ($fjmys as $fjmy) {
				$user = MemberManager::getByUsername($fjmy->username);
				if (!$user) {
					$fjmy->delete();
				} else {
					if($fjmy->thumbs==''){
						$fjmy->thumbs.=$fjmy->thumb;
						$fjmy->thumbs=$fjmy->thumbs?($fjmy->thumbs.','.$fjmy->thumb1):$fjmy->thumbs;
						$fjmy->thumbs=$fjmy->thumbs?($fjmy->thumbs.','.$fjmy->thumb2):$fjmy->thumbs;
						$fjmy->save();
					}
					$searchInfo = FJMYManager::createSearchInfo($fjmy);
					$searchInfo->save();
					
					$infodata=FJMYDataManager::getById($fjmy->itemid);
					InfoController::Info_Banword($fjmy,$infodata);
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
