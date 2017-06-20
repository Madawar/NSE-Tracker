<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class ProcessEquity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process';

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
        if (!Schema::hasTable('stock_tracking')) {
            Schema::create('stock_tracking', function (Blueprint $table) {
                $table->increments('id');
                $table->string('stock');
                $table->double('value');
                $table->date('date');
            });
        }

        $stocks = DB::table('stocks')->where('date', '>', Carbon::today())->get();
        $stocks = $stocks->map(function ($item, $key) {
            //$item->orig_stock = $item->stock;
            $item->stock = explode('Ltd', $item->stock)[0];
            $item->stock = explode('Ord', $item->stock)[0];
            $item->stock = str_replace("Ltd", "", $item->stock);
            $item->stock = str_replace("Ord", "", $item->stock);
            $item->stock = str_replace("Ord.", "", $item->stock);
            $item->stock = str_replace("0rd", "", $item->stock);
            $item->stock = str_replace("AIMS", "", $item->stock);
            $item->stock = str_replace("Co. ", "", $item->stock);
            $item->stock = str_replace("Co ", "", $item->stock);
            $item->stock = str_replace("CO ", "", $item->stock);
            $item->stock = str_replace("(K).", "", $item->stock);
            $item->stock = preg_replace('#\d+(?:\.\d{1,2})?#', '', $item->stock);
            $item->value = str_replace(",", "", $item->value);
            $item->stock = trim($item->stock);
            return $item;
        });
        foreach ($stocks as $stock) {
            DB::table('stock_tracking')->insert(
                array_except((array)$stock, 'id')
            );
        }
    }
}
