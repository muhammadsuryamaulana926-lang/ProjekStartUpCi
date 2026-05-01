<?php

namespace App\Models;

use CodeIgniter\Model;

class M_login_history extends Model
{
    protected $table         = 'login_history';
    protected $primaryKey    = 'id_login_history';
    protected $allowedFields = ['id_user', 'nama_pengguna', 'email', 'ip_address', 'nama_perangkat', 'web_browser', 'status', 'tanggal_login'];
    protected $useTimestamps = false;

    // Catat login baru sebagai aktif, nonaktifkan sesi sebelumnya
    public function catat_login(array $data): void
    {
        // Nonaktifkan semua sesi aktif user ini
        $this->where('id_user', $data['id_user'])
             ->where('status', 'aktif')
             ->set(['status' => 'tidak_aktif'])
             ->update();

        $this->insert(array_merge($data, [
            'status'        => 'aktif',
            'tanggal_login' => date('Y-m-d H:i:s'),
        ]));
    }

    // Nonaktifkan sesi aktif saat logout
    public function catat_logout(int $id_user): void
    {
        $this->where('id_user', $id_user)
             ->where('status', 'aktif')
             ->set(['status' => 'tidak_aktif'])
             ->update();
    }

    // Ambil semua history dengan filter opsional
    public function semua_history(array $filters = []): array
    {
        $builder = $this->orderBy('tanggal_login', 'DESC');

        if (!empty($filters['id_user'])) {
            $builder->where('id_user', $filters['id_user']);
        }

        if (!empty($filters['timeframe'])) {
            match($filters['timeframe']) {
                'today' => $builder->where('DATE(tanggal_login)', date('Y-m-d')),
                'month' => $builder->where('MONTH(tanggal_login)', date('m'))->where('YEAR(tanggal_login)', date('Y')),
                default => null,
            };
        }

        return $builder->findAll();
    }
}
