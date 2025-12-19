<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapAbsenController extends Controller
{
    public function index() {
        return view('walikelas.rekap.index');
    }
}
