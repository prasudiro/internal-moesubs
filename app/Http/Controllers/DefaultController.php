<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use View;
use Auth;
use Mail;
use App\Setoran;
use App\Laporan;
use App\LaporanIsi;
use App\Rilisan;
use App\User;
use App\UserSession;

class DefaultController extends Controller
{
    //Default validation
    public function __construct()
    {
        $this->middleware('auth');

        $setoran_edit     = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->get()
                                ->count();

        $tanggal_edit     = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->orderBy('updated_at', 'desc')
                                ->first();

        $setoran_qc       = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->count();

        $tanggal_qc       = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->orderBy('updated_at', 'desc')
                                ->first();

        $laporan_qc       = LaporanIsi::where('updated_at', '>=', Carbon::today())
                                ->where('status', '=', '0')
                                ->count();

        $tanggal_laporan  = LaporanIsi::where('updated_at', '>=', Carbon::today())
                                ->where('status', '=', '0')
                                ->orderBy('updated_at', 'desc')
                                ->first();

        $total_pemberitahuan = $setoran_edit + $setoran_qc + $laporan_qc;

        View::share('setoran_edit', $setoran_edit);
        View::share('setoran_qc', $setoran_qc);
        View::share('laporan_qc', $laporan_qc);
        View::share('total_pemberitahuan', $total_pemberitahuan);
        View::share('tanggal_edit', $tanggal_edit);
        View::share('tanggal_qc', $tanggal_qc);
        View::share('tanggal_laporan', $tanggal_laporan);
    }

    //Get homepage with template
    public function index( Request $request)
    {
        $user_info = Auth::user();

        //Call setoran edit data
        $edit['today'] = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->count();
        $edit['week']  = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::parse('last monday')->startOfDay(),
                                    Carbon::parse('next friday')->endOfDay(),
                                ])
                                ->count();
        $edit['month'] = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::now()->startOfMonth(),
                                    Carbon::now()->endOfMonth(),
                                ])
                                ->count();
        $edit['year']  = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::now()->startOfYear(),
                                    Carbon::now()->endOfYear(),
                                ])->count();
        $edit['total'] = Setoran::where('setoran_type', '=', '0')
                                ->where('status', '=', '0')
                                ->count();


        //Call setoran qc data
        $qc['today'] = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->where('updated_at', '>=', Carbon::today())
                                ->count();
        $qc['week']  = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::parse('last monday')->startOfDay(),
                                    Carbon::parse('next friday')->endOfDay(),
                                ])
                                ->count();
        $qc['month'] = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::now()->startOfMonth(),
                                    Carbon::now()->endOfMonth(),
                                ])
                                ->count();
        $qc['year']  = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->whereBetween('updated_at', [
                                    Carbon::now()->startOfYear(),
                                    Carbon::now()->endOfYear(),
                                ])
                                ->count();
        $qc['total'] = Setoran::where('setoran_type', '=', '1')
                                ->where('status', '=', '0')
                                ->count();

        //Call laporan qc data
        $laporan['today'] = LaporanIsi::where('updated_at', '>=', Carbon::today())
                                        ->where('status', '=', '0')
                                        ->count();
        $laporan['week']  = LaporanIsi::whereBetween('updated_at', [
                                            Carbon::parse('last monday')->startOfDay(),
                                            Carbon::parse('next friday')->endOfDay(),
                                        ])
                                        ->where('status', '=', '0')
                                        ->count();
        $laporan['month'] = LaporanIsi::whereBetween('updated_at', [
                                            Carbon::now()->startOfMonth(),
                                            Carbon::now()->endOfMonth(),
                                        ])
                                        ->where('status', '=', '0')
                                        ->count();
        $laporan['year']  = LaporanIsi::whereBetween('updated_at', [
                                            Carbon::now()->startOfYear(),
                                            Carbon::now()->endOfYear(),
                                        ])
                                        ->where('status', '=', '0')
                                        ->count();
        $laporan['total'] = LaporanIsi::where('status', '=', '0')->count();

        //Call rilisan data
        $rilisan['today'] = Rilisan::where('tanggal', '>=', Carbon::today())->count();
        $rilisan['week']  = Rilisan::whereBetween('tanggal', [
                                        Carbon::parse('last monday')->startOfDay(),
                                        Carbon::parse('next friday')->endOfDay(),
                                    ])->count();
        $rilisan['month'] = Rilisan::whereBetween('tanggal', [
                                        Carbon::now()->startOfMonth(),
                                        Carbon::now()->endOfMonth(),
                                    ])->count();
        $rilisan['year']  = Rilisan::whereBetween('tanggal', [
                                        Carbon::now()->startOfYear(),
                                        Carbon::now()->endOfYear(),
                                    ])->count();
        $rilisan['total'] = Rilisan::count();

        $activity['list'] = UserSession::where('user_id', '=', $user_info['id'])->orderBy('users_sessions_time', 'desc')->limit(5)->get()->toArray();
        $activity['last'] = UserSession::where('user_id', '=', $user_info['id'])->orderBy('users_sessions_time', 'desc')->first();

        // //Update session
        //   $session_detail = array(
        //                           "full_url"        => base64_encode($request->fullUrl()),
        //                     );

        //   $data_session   = array(
        //                           "users_sessions_detail" => json_encode($session_detail),
        //                           "user_id"               => $user_info['id'],
        //                           "users_sessions_time"   => date('Y-m-d H:i:s'),
        //                           "users_sessions_module" => 'Dasbor',
        //                           "users_sessions_action" => 'visit',
        //                     );

        //   $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
        //                                 ->where('users_sessions_module', '=', 'Dasbor')
        //                                 ->where('users_sessions_action', '=', 'visit')
        //                                 ->first();

        //     //Check if this session's page already exists, update it or just create a now of it
        //     if (count($check_session) > 0)
        //     {
        //         $update_session = UserSession::where('users_sessions_id', '=', $check_session['users_sessions_id'])->update(array('users_sessions_time' => date('Y-m-d H:i:s')));
        //     }
        //     else
        //     {
        //         $create_session = UserSession::insert($data_session);
        //     }
        //     //End of it
        // //End of update session

    	 return view('html.dasbor.index')
                ->with('user_info', $user_info)
                ->with('edit', $edit)
                ->with('qc', $qc)
                ->with('laporan', $laporan)
                ->with('rilisan', $rilisan)
                ->with('activity', $activity);
    }

    public function tests()
    {
        // $user_info = Auth::user();

        // Mail::send(['test' => 'testing'], ['user' => $user_info], function ($m) use ($user_info) {
        //     $m->from('admin@moesubs.com', 'Moesubs');
        //     $m->to($user_info['email'], $user_info['name'])->subject('Testing Mail!');
        // });

      return redirect('dasbor');
    }
}
