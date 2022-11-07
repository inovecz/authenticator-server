<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $data = DB::table('users')
            ->select(DB::raw('count(*) as usersCount, SUM(login_count) as loginCount, AVG(average_score) as averageScore'))
            ->distinct()
            ->first();

        $usersCount = (int)$data->usersCount ?: 0;
        $loginCount = (int)$data->loginCount ?: 0;
        $averageScore = (float)$data->averageScore ?: 0;
        return view('admin.dashboard', compact('usersCount', 'loginCount', 'averageScore'));
    }
}
