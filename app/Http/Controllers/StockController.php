<?php

namespace App\Http\Controllers;

use App\ActiveStock;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = DB::table('active_stocks')->get();
        $stocks = $stocks->map(function ($item, $key) {
            $temp = DB::table('stock_tracking')->where('date', '=', Carbon::today()->format('Y-m-d'))->where('stock', $item->stock)->first();
            $item->currentBid = $temp->value;
            $item->boughtValue = $item->value * $item->stockNo;
            $item->currentValue = $item->currentValue * $item->stockNo;
            return $item;
        });
        return view('active_stocks')->with(compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = DB::table('stock_tracking')->where('date', '>=', Carbon::today()->format('Y-m-d'))->get();
        $x = [];
        foreach ($stocks as $stock) {
            $x[$stock->stock] = $stock->stock;
        }
        $stocks = $x;

        return view('active_stock')->with(compact('stocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = Carbon::today();
        ActiveStock::create(array_except($data, '_token'));
        return redirect()->action('StockController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        ActiveStock::find($id)->update($request->all());
        return redirect()->action('StockController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('active_stocks')->destroy($id);
        return redirect()->action('StockController@index');
    }
}
