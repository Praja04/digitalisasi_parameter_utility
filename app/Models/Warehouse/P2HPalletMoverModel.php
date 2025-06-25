<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class P2HPalletMoverModel extends Model
{
    //
    protected $table = 'p2h_pallet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal',
        'jenis_p2h',
        'nomor_unit',
        'dept',
        'check_air_accu',
        'check_battery',
        'check_body_unit',
        'check_klakson',
        'check_roda',
        'check_sistem_kemudi',
        'check_kebersihan_unit',
        'check_kunci_pm',
        'check_hydraulic',
        'shift',
        'operator_name',
        'catatan',
    ];

}
