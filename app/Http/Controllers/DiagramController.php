<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiagramController extends Controller
{

    public function __invoke()
    {

        return view('chart.chart');
    }
    public function MontlySales()
    {
        $salesData = DB::table('bills')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(totalg) as total_sales'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        return view('chart.monthly', compact('salesData'));
    }
    public function dailysales(){
        $salesData = DB::table('bills')
    ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(totalg) as total_sales'))
    ->groupBy(DB::raw('DATE(created_at)'))
    ->get();
return view('chart.daily', compact('salesData'));


    }
    public function hourlySalesalltime() {
        $salesData = DB::table('bills')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(totalg) as total_sales'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->get();

        return view('chart.mostDaily', compact('salesData'));
    }



    public function hourlySales() {
        // Get today's date
        $today = Carbon::today();

        // Fetch sales data for today, grouped by hour
        $salesData = DB::table('bills')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(totalg) as total_sales'))
            ->whereDate('created_at', $today)  // Filter by today's date
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->get();

        return view('chart.hourly', compact('salesData'));
    }


}
