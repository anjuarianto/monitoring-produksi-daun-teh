<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HasilHasKaryawan extends Pivot
{
    use HasFactory;

    protected $table = 'hasil_has_karyawan';

    protected $fillable = ['hasil_id', 'user_id'];

    public $timestamps = false;

    public function hasil()
    {
        return $this->belongsTo(Hasil::class, 'hasil_id');
    }
}
