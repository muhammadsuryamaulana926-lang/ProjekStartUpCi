<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola percobaan login dan mekanisme lockout akun
class M_login extends Model
{
    protected $table         = 'login_attempts';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['email', 'ip_address', 'attempts', 'last_attempt_at', 'locked_until'];
    protected $useTimestamps = false;

    // Maksimal percobaan login sebelum akun dikunci
    const MAX_ATTEMPTS = 5;

    // Durasi penguncian akun dalam menit
    const LOCKOUT_MINS = 15;

    // Mengambil record percobaan login berdasarkan email dan IP address
    public function ambil_record(string $email, string $ip)
    {
        return $this->where('email', $email)->where('ip_address', $ip)->first();
    }

    // Mengecek apakah akun sedang dalam kondisi terkunci
    public function cek_terkunci(string $email, string $ip): bool
    {
        $rec = $this->ambil_record($email, $ip);
        if (!$rec || !$rec['locked_until']) return false;
        return strtotime($rec['locked_until']) > time();
    }

    // Menghitung sisa waktu kunci akun dalam menit
    public function sisa_menit_kunci(string $email, string $ip): int
    {
        $rec = $this->ambil_record($email, $ip);
        if (!$rec || !$rec['locked_until']) return 0;
        return (int) ceil((strtotime($rec['locked_until']) - time()) / 60);
    }

    // Mencatat percobaan login yang gagal, mengunci akun jika melebihi batas maksimal
    public function catat_gagal(string $email, string $ip): void
    {
        $rec = $this->ambil_record($email, $ip);
        $now = date('Y-m-d H:i:s');

        // Jika belum ada record, buat baru dengan attempts = 1
        if (!$rec) {
            $this->insert(['email' => $email, 'ip_address' => $ip, 'attempts' => 1, 'last_attempt_at' => $now]);
            return;
        }

        $attempts = $rec['attempts'] + 1;

        // Kunci akun jika sudah mencapai batas maksimal percobaan
        $locked = $attempts >= self::MAX_ATTEMPTS
            ? date('Y-m-d H:i:s', strtotime('+' . self::LOCKOUT_MINS . ' minutes'))
            : null;

        $this->where('id', $rec['id'])->set([
            'attempts'        => $attempts,
            'last_attempt_at' => $now,
            'locked_until'    => $locked,
        ])->update();
    }

    // Menghapus record percobaan login setelah berhasil login (reset lockout)
    public function hapus_record(string $email, string $ip): void
    {
        $this->where('email', $email)->where('ip_address', $ip)->delete();
    }
}
