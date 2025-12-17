<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    function admin()
    {
        return view('admin.dashboard');
    }

    function guru()
    {
        return view('guru.dashboard');
    }

    function walikelas()
    {
        return view('walikelas.dashboard');
    }

    function sekretaris()
    {
        return view('sekretaris.dashboard');
    }
}
