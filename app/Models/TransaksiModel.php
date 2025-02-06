<?php 
namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table         = 'pembayaran'; // Nama tabel
    protected $primaryKey    = 'id'; // Primary key tabel
    protected $allowedFields = ['id_pasien', 'nm_pasien', 'nm_user','no_antrian', 'status']; // Kolom yang boleh diisi

    // Aktifkan timestamps
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aturan validasi
    public function simpanTransaksi($data)
    {
        return $this->insert($data); // Insert data ke tabel
    }

    // Ambil transaksi berdasarkan ID pasien
    public function getTransaksiByPasien($id_pasien)
    {
        return $this->where('id_pasien', $id_pasien)->findAll(); // Ambil semua data berdasarkan id_pasien
    }
    // Update status pembayaran
    public function updateStatusPembayaran($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function getAllWithTransaksi()
{
    return $this->db->table('pembayaran')
        ->select('pembayaran.*, riwayat_kesehatan.keterangan, pasien.nm_pasien, users.nm_user')
        ->join('riwayat_kesehatan', 'riwayat_kesehatan.id = pembayaran.id')
        ->join('pasien', 'pasien.id_pasien = pembayaran.id')
        ->join('users', 'users.id_user = pembayaran.id')
        ->get()
        ->getResultArray();
}

}

