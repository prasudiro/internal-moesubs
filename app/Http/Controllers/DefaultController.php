<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Setoran;
use App\Laporan;
use App\LaporanIsi;

class DefaultController extends Controller
{
    //Default validation
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Get homepage with template
    public function index()
    {
        $user_info = Auth::user();

        //Call setoran edit data
        $edit['today'] = Setoran::where('setoran_type', '=', 1)
                                        ->where('updated_at', '>=', Carbon::today())->count();
        $edit['week']  = Setoran::where('setoran_type', '=', 1)
                                        ->whereBetween('updated_at', [
                                            Carbon::parse('last monday')->startOfDay(),
                                            Carbon::parse('next friday')->endOfDay(),
                                        ])->count();
        $edit['month'] = Setoran::where('setoran_type', '=', 1)
                                        ->whereBetween('updated_at', [
                                            Carbon::now()->startOfMonth(),
                                            Carbon::now()->endOfMonth(),
                                        ])->count();
        $edit['year']  = Setoran::where('setoran_type', '=', 1)
                                        ->whereBetween('updated_at', [
                                            Carbon::now()->startOfYear(),
                                            Carbon::now()->endOfYear(),
                                        ])->count();

        //Call setoran qc data
        $qc['today'] = Setoran::where('setoran_type', '=', 2)
                                        ->where('updated_at', '>=', Carbon::today())->count();
        $qc['week']  = Setoran::where('setoran_type', '=', 2)
                                        ->whereBetween('updated_at', [
                                            Carbon::parse('last monday')->startOfDay(),
                                            Carbon::parse('next friday')->endOfDay(),
                                        ])->count();
        $qc['month'] = Setoran::where('setoran_type', '=', 2)
                                        ->whereBetween('updated_at', [
                                            Carbon::now()->startOfMonth(),
                                            Carbon::now()->endOfMonth(),
                                        ])->count();
        $qc['year']  = Setoran::where('setoran_type', '=', 2)
                                        ->whereBetween('updated_at', [
                                            Carbon::now()->startOfYear(),
                                            Carbon::now()->endOfYear(),
                                        ])->count();

        //Call laporan qc data
        $laporan['today'] = LaporanIsi::where('updated_at', '>=', Carbon::today())->count();
        $laporan['week']  = LaporanIsi::whereBetween('updated_at', [
                                        Carbon::parse('last monday')->startOfDay(),
                                        Carbon::parse('next friday')->endOfDay(),
                                    ])->count();
        $laporan['month'] = LaporanIsi::whereBetween('updated_at', [
                                        Carbon::now()->startOfMonth(),
                                        Carbon::now()->endOfMonth(),
                                    ])->count();
        $laporan['year']  = LaporanIsi::whereBetween('updated_at', [
                                        Carbon::now()->startOfYear(),
                                        Carbon::now()->endOfYear(),
                                    ])->count();


    	return view('html.dasbor.index')
                ->with('user_info', $user_info)
                ->with('edit', $edit)
                ->with('qc', $qc)
                ->with('laporan', $laporan);
    }
}
