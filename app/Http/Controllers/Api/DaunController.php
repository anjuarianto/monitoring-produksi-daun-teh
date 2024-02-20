<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Timbangan;
use App\Models\User;
use Illuminate\Http\Request;

class DaunController extends Controller
{
    public function get() {
        
        $mandor = User::find(request()->get('mandor_id'));
       
        if(request()->get('mandor_id')) {
            $data = Timbangan::daun(request()->get('laporan_id'), request()->get('mandor_id'));
        } else {
            $data = [];
        }
        return response()->json([
            'data' => $data,
            'component' => view('daun.component.timbangan-body', compact('data', 'mandor'))->render()
        ]);
    }
}
