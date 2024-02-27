<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanTableController extends Controller
{
    public function index() {
        return view('laporan.table');
    }
}
