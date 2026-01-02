<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;

class DebugController extends Controller
{
    public function agendaDebug()
    {
        $user = Auth::user();

        $response = [
            'user_id' => $user->id ?? null,
            'user_name' => $user->name ?? null,
            'all_agendas_count' => DB::table('agenda')->count(),
            'all_agendas_sample' => DB::table('agenda')->orderBy('id', 'desc')->limit(3)->get(),
            'user_agendas_count' => DB::table('agenda')->where('users_id', $user->id)->count(),
            'user_agendas' => DB::table('agenda')->where('users_id', $user->id)->orderBy('tanggal', 'desc')->limit(3)->get(),
            'signed_agendas_count' => DB::table('agenda')->where('ditandatangani_oleh', $user->id)->count(),
            'signed_agendas' => DB::table('agenda')->where('ditandatangani_oleh', $user->id)->orderBy('tanggal', 'desc')->limit(3)->get(),
            'combined_count' => DB::table('agenda')
                ->where(function($q) use ($user) {
                    $q->where('users_id', $user->id)
                      ->orWhere('ditandatangani_oleh', $user->id);
                })
                ->count(),
        ];

        return response()->json($response);
    }
}
