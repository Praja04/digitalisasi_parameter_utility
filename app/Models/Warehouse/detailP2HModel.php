<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class detailP2HModel extends Model
{
    //
    protected $table = 'detail_p2h';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_p2h','cek_baterai',
        'cek_fork',
        'kondisi_body_kebersihan',
        'lampu_kiri',
        'lampu_kanan',
        'lampu_sorot',
        'lampu_sign_depan_kanan',
        'lampu_sign_depan_kiri',
        'kipas_belakang',
        'rantai_lift',
        'sistem_hidrolik',
        'kondisi_axle',
        'sistem_kemudi',
        'panel_display',
        'jam_operasional',
        'air_aki',
        'klakson',
        'buzzer_mundur',
        'kaca_spion',
        'kondisi_ban',
        'fungsi_rem',
        'shift',
        'operator_name',
        'catatan',
    ];

    public function data()
    {
        return $this->belongsTo(P2HModel::class, 'id_p2h');
    }

    public function calculateKelayakan()
    {
        $kategori30 = [
            'cek_baterai',
            'cek_fork',
            'kondisi_body_kebersihan',
            'lampu_kiri',
            'lampu_kanan',
            'lampu_sorot',
            'lampu_sign_depan_kanan',
            'lampu_sign_depan_kiri',
            'kipas_belakang',
        ];

        $kategori50 = [
            'rantai_lift',
            'sistem_hidrolik',
            'kondisi_axle',
            'sistem_kemudi',
            'panel_display',
            'jam_operasional',
            'air_aki',
        ];

        $kategori20 = [
            'klakson',
            'buzzer_mundur',
            'kaca_spion',
            'kondisi_ban',
        ];

        $persentase = 0;

        // Hitung dari kategori 30%
        $ok30 = collect($kategori30)->filter(fn ($key) => $this->$key == 1)->count();
        $persentase += ($ok30 / count($kategori30)) * 30;

        // Hitung dari kategori 50%
        $ok50 = collect($kategori50)->filter(fn ($key) => $this->$key == 1)->count();
        $persentase += ($ok50 / count($kategori50)) * 50;

        // Hitung dari kategori 20%
        $ok20 = collect($kategori20)->filter(fn ($key) => $this->$key == 1)->count();
        $persentase += ($ok20 / count($kategori20)) * 20;

        // Bulatkan ke integer
        return round($persentase);
    }
    
    

}
