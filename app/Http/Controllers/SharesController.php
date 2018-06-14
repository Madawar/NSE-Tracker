<?php

namespace App\Http\Controllers;

use App\StockTracking;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SharesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = DB::table('stock_tracking')->select('stock', 'value')->where('date', '>=', Carbon::today()->format('Y-m-d'))->distinct()->orderBy('value')->paginate();
        $stocks = $stocks->map(function ($item, $key) {
            $previous = DB::table('stock_tracking')->where('date', '<', Carbon::today())->where('stock', $item->stock)->get();
            $item->max = $previous->max('value');
            $item->min = $previous->min('value');
            $item->avg = $previous->avg('value');
            if ($item->value < $item->avg) {
                $item->color = 'danger';
                $item->percentage = 100 - ($item->value / $item->avg) * 100;
            } elseif ($item->value > $item->avg) {
                $item->color = 'success';
                $item->percentage = 100 - ($item->value / $item->avg) * 100;
            } else {
                $item->color = "";
                $item->percentage = 0;
            }

            return $item;
        });

        $stocks = $stocks->sortBy('percentage');
        return view('allshares')->with(compact('stocks'));
    }

    public function page(Request $request)
    {

        $stocks = DB::table('stock_tracking')->select(DB::raw('stock as id'), 'stock', 'value')->where('stock','like','%'.$request->filter.'%')->where('date', '>=', Carbon::today()->format('Y-m-d'))->distinct()->orderBy('value')->paginate(100);
        $stocks->map(function ($item, $key) {
            $previous = DB::table('stock_tracking')->where('date', '<', Carbon::today())->where('stock', $item->stock)->get();
            $item->max = $previous->max('value');
            $item->min = $previous->min('value');
            $item->avg = $previous->avg('value');
            $item->chart[] = ["{type: 'date', label: 'Date'}", "{type: 'number', label: 'Value'}"];
            foreach ($previous as $key => $value) {
                $x = Carbon::createFromFormat('Y-m-d', $value->date);
                $item->chart[++$key] = ["Date({$x->format('Y')}, {$x->format('m')}, {$x->format('d')})", floatval($value->value)];

            }
            //array_splice($item->chart, 0, 1);
            if ($item->value < $item->avg) {
                $item->color = '<span class="status-icon bg-danger"></span> Downwards';
                $item->percentage = 100 - ($item->value / $item->avg) * 100;
            } elseif ($item->value > $item->avg) {
                $item->color = '<span class="status-icon bg-success"></span> Upwards';
                $item->percentage = 100 - ($item->value / $item->avg) * 100;
            } else {
                $item->color = "";
                $item->percentage = 0;
            }

            return $item;
        });

        return $stocks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $stocks = StockTracking::where('stock', $id)->groupBy('date', 'stock')->get();
        $stocks = $stocks->map(function ($item, $key) {
            $item->date = Carbon::parse($item->date)->format('Y-m-d');
            return $item;
        });
        return view('graph')->with(compact('stocks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
