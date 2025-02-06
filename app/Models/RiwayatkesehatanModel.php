<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatkesehatanModel extends Model {
    protected $DBGroup              = 'default';
    protected $table                = 'riwayat_kesehatan';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = [ 'nm_user', 'id_pasien', 'no_antrian', 'nm_pasien', 'tgl_daftar', 'keluhan', 'nm_obat', 'jumlah', 'keterangan', 'id_obat', 'diagnosa', 'tindakan' ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getRiwayatByPasien( $id_pasien ) {
        return $this->select( 'riwayat_kesehatan.*, obat.harga, obat.nm_obat, pasien.nama as nm_user' )
        ->join( 'obat', 'riwayat_kesehatan.id_obat = obat.id_obat', 'left' )
        ->join( 'pasien', 'riwayat_kesehatan.id_pasien = pasien.id_pasien', 'left' )
        ->where( 'riwayat_kesehatan.id_pasien', $id_pasien )
        ->findAll();
    }

    public function getRekamMedis( $id_pasien ) {
        return $this->select( '
        riwayat_kesehatan.no_antrian,
        riwayat_kesehatan.diagnosa,
        riwayat_kesehatan.keterangan,
		riwayat_kesehatan.nm_user,
        obat.nm_obat,
        pasien.nm_pasien,
        pasien.id_pasien,
		pasien.tgl_daftar
       
    ' )
        ->join( 'obat', 'riwayat_kesehatan.id_obat = obat.id_obat', 'left' )
        ->join( 'pasien', 'riwayat_kesehatan.id_pasien = pasien.id_pasien', 'left' )
        ->where( 'riwayat_kesehatan.id_pasien', $id_pasien )
        ->findAll();
    }

    public function getRiwayatByPasienRekam( $id, $tgl_daftar ) {
        return $this->select( '
        riwayat_kesehatan.*,
        obat.harga AS harga,
        obat.nm_obat AS nm_obat,
        pasien.nm_pasien AS nm_pasien
    ' )
        ->join( 'obat', 'riwayat_kesehatan.id_obat = obat.id_obat', 'left' )
        ->join( 'pasien', 'riwayat_kesehatan.id_pasien = pasien.id_pasien', 'left' )
        ->where( 'riwayat_kesehatan.id_pasien', $id )
        ->where( 'riwayat_kesehatan.tgl_daftar', $tgl_daftar ) // Filter berdasarkan tanggal
        ->findAll();
    }

    public function insertData( $data ) {
        return $this->insert( $data );
    }

    public function getRiwayatByTanggal( $id_pasien, $tgl_daftar ) {
        $builder = $this->db->table( 'riwayat_kesehatan' );
        $builder->where( 'id_pasien', $id_pasien );
        $builder->where( 'tgl_daftar', $tgl_daftar );

        return $builder->get()->getResultArray();
    }

    public function getRiwayatWithUser( $id_user ) {
        return $this->select( 'riwayat_kesehatan.*, users.nm_user' )
        ->join( 'users', 'users.id_user = riwayat_kesehatan.id' )
        ->where( 'riwayat_kesehatan.id', $id_user )
        ->findAll();
    }
}
