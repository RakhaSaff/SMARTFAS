<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_barang',
        'jenis_barang',
        'tempat_utama',
        'sub_lokasi',
        'lantai_kelas',
        'tempat_label',
        'deskripsi',
        'foto_atas',
        'foto_bawah',
        'foto_kanan',
        'foto_kiri',
        'foto_depan',
        'foto_belakang',
        'status',
        'nomor_tiket',
        'catatan_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Label status yang mudah dibaca
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'menunggu'   => 'Menunggu',
            'diproses'   => 'Sedang Diproses',
            'selesai'    => 'Selesai',
            'ditolak'    => 'Ditolak',
            default      => 'Tidak Diketahui',
        };
    }

    /**
     * Warna badge status
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'menunggu' => 'warning',
            'diproses' => 'info',
            'selesai'  => 'success',
            'ditolak'  => 'danger',
            default    => 'secondary',
        };
    }

    /**
     * URL semua foto
     */
    public function getFotoUrlsAttribute()
    {
        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        $urls = [];
        foreach ($sisi as $s) {
            $field = 'foto_' . $s;
            $urls[$s] = $this->$field ? asset('storage/' . $this->$field) : null;
        }
        return $urls;
    }
}
