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
            $list = Timbangan::daun(request()->get('laporan_id'), request()->get('mandor_id'));
        } else {
            $list = [];
        }

        $total = Timbangan::daunTotal(request()->get('laporan_id'), request()->get('mandor_id'));

        return response()->json([
            'component' => [
                'body' => view('daun.component.timbangan-body', compact('list', 'mandor'))->render(),
                'footer' => view('daun.component.timbangan-footer', compact('total', 'mandor'))->render(),
            ]
        ]);
    }
}
