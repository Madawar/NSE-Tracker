<?php

namespace App\Console\Commands;

use App\Mail\ShareAlerts;
use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stocks = DB::table('stock_tracking')->where('date', '>=', Carbon::today()->format('Y-m-d'))->get();
        $alertBuyStocks = array();
        $alertRisingStocks = array();
        $alertTrackingStocks = array();
        $alertDropStocks = array();
        foreach ($stocks as $stock) {

            $previous = DB::table('stock_tracking')->where('date', '<', Carbon::today())->where('stock', $stock->stock)->get();
            $minValue = $previous->min('value');
            $maxValue = $previous->max('value');
            $avgValue = $previous->avg('value');


            if ((double)$stock->value < $minValue or $stock->value < $avgValue) {
                array_push($alertBuyStocks, $stock);
            }
            if ((double)$stock->value > $maxValue) {
                array_push($alertRisingStocks, $stock);
            }

            $isTracked = DB::table('active_stocks')->where('stock', $stock->stock)->first();


            if (count($isTracked) > 0) {
                if($stock->value < $isTracked->stopOrder){
                    array_push($alertDropStocks, $stock);
                }
                $stock->origVal = $isTracked->value;
                $stock->stockNo = $isTracked->stockNo;
                array_push($alertTrackingStocks, $stock);
            }

        }
        Mail::to('dwanyoike@codedcell.com')
            ->send(new ShareAlerts($alertRisingStocks, $alertBuyStocks, $alertTrackingStocks,$alertDropStocks));
        var_dump($alertRisingStocks);
        var_dump($alertBuyStocks);
        var_dump($alertTrackingStocks);
    }

}
