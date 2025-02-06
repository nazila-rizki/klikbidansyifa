<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\BidanModel;
use App\Models\ObatModel;
use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\TransaksiModel;
use App\Models\RiwayatkesehatanModel;
use Dompdf\Dompdf;
use CodeIgniter\HTTP\IncomingRequest;
use Dompdf\Options;

class BidanController extends BaseController {
    protected $BidanModel;
    protected $obatModel;
    protected $UserModel;
    protected $AdminModel;
    protected $RiwayatKesehatan;
    protected $transaksiModel;

    public function __construct() {
        $this->transaksiModel = new TransaksiModel();
        // Inisialisasi model
        $this->BidanModel = new BidanModel();
        $this->obatModel = new ObatModel();
        $this->AdminModel = new AdminModel();
        $this->RiwayatKesehatan = new RiwayatkesehatanModel();
        $this->UserModel = new UserModel();
    }

    // Menampilkan daftar pasien

    public function index() {
        $data[ 'pasien' ] = $this->BidanModel->setTablePasien()->getAll();
        return view( 'bidan/index', $data );
    }

    // Menampilkan daftar riwayat kesehatan

    public function home() {
        // Ambil nama bidan dari session atau database
        $id_user = session()->get( 'id_user' );
        // Ambil ID user dari session
        $user = $this->UserModel->find( $id_user );
        // Ambil data user dari database

        if ( !$user || $user[ 'role' ] !== 'bidan' ) {
            return redirect()->back()->with( 'error', 'Akses tidak valid.' );
        }

        $id_obat = $this->request->getVar( 'id_obat' );
        $jumlah = ( int ) $this->request->getVar( 'jumlah' );
        $tgl_daftar = $this->request->getVar( 'tgl_daftar' );
        // Cek ketersediaan stok obat
        $obat = $this->obatModel->find( $id_obat );
        if ( !$obat ) {
            return redirect()->back()->with( 'error', 'Obat tidak ditemukan.' );
        }

        if ( $obat[ 'stok' ] < $jumlah ) {
            return redirect()->back()->with( 'error', 'Stok obat tidak mencukupi.' );
        }

        $this->obatModel->update( $id_obat, [ 'stok' => $obat[ 'stok' ] - $jumlah ] );

        $this->RiwayatKesehatan->insert( [
            'id_riwayat' => $this->request->getVar( 'id_riwayat' ),
            'nm_user' => $user[ 'nm_user' ],
            'no_antrian' => $this->request->getVar( 'no_antrian' ),
            'id_pasien' => $this->request->getVar( 'id_pasien' ),
            'nm_pasien' => $this->request->getVar( 'nm_pasien' ),
            'keluhan' => $this->request->getVar( 'keluhan' ),
            'diagnosa' => $this->request->getVar( 'diagnosa' ),
            'tgl_daftar' => $tgl_daftar,
            'id_obat' => $this->request->getVar( 'id_obat' ),
            'nm_obat' => $this->request->getVar( 'nm_obat' ),
            'jumlah' => $this->request->getVar( 'jumlah' ),
            'keterangan' => $this->request->getVar( 'keterangan' ),
        ] );

        $data = [
            'pasien' => $this->request->getVar(),
            'nm_user' => $this->UserModel->find( $this->request->getVar( 'nm_user' ) ), // Kirim nama bidan ke view
            'riwayat' => $this->BidanModel
            ->setTableRiwayat()
            ->where( 'id_pasien', $this->request->getVar( 'id_pasien' ) )
            ->where( 'tgl_daftar', $tgl_daftar ) // Filter berdasarkan tgl_daftar
            ->groupBy( 'tgl_daftar' ) // Mengelompokkan data berdasarkan tgl_daftar
            ->findAll(),

            'obat' => $this->obatModel->find( $this->request->getVar( 'id_obat' ) )

        ];
        log_message( 'debug', 'Riwayat data: ' . print_r( $data[ 'riwayat' ], true ) );
        return view( 'bidan/rekam', $data );
    }

    public function detail( $id, $tgl_daftar ) {
        $adminModel = new AdminModel();
        $RiwayatKesehatanModel = new RiwayatkesehatanModel();

        // Ambil data riwayat kesehatan ( bisa lebih dari satu baris )
        $riwayat = $this->RiwayatKesehatan->getRiwayatByPasienRekam( $id, $tgl_daftar );
        $id_obat = $riwayat[ 0 ][ 'id_obat' ];
        $obat = $this->obatModel->where( 'id_obat', $id_obat )->first();

        // Jika tidak ada data sama sekali
        if ( empty( $riwayat[ 0 ][ 'nm_user' ] ) ) {
            return redirect()->to( '/BidanController/home' )->with( 'error', 'Data pengguna tidak ditemukan.' );
        }

        // Ambil baris pertama untuk menampilkan informasi pasien di form
        $firstRow  = $riwayat[ 0 ];
        $obatRow = isset( $obat[ 0 ] ) ? $obat[ 0 ] : null;
        // Atau jika Anda punya tabel pasien terpisah, silakan ambil dari model pasien
        // Siapkan data untuk view
        $data = [
            'riwayat'    => $riwayat,
            // Data 'pasien' singkat dari baris pertama ( kalau memang join-nya sudah ada )
            'pasien' => [
                'id_pasien'   => $firstRow[ 'id_pasien' ] ?? '',
                'nm_pasien'   => $firstRow[ 'nm_pasien' ] ?? '',
                'tgl_daftar'  => $firstRow[ 'tgl_daftar' ] ?? '',
                'no_antrian'  => $firstRow[ 'no_antrian' ] ?? '',
                'diagnosa'  => $firstRow[ 'diagnosa' ] ?? '',
            ],
            'obat' => [
                'nm_obat'   => $obatRow[ 'nm_obat' ] ?? '',
                'harga'   => $obatRow[ 'harga' ] ?? '',
            ],
            'diagnosa' => $firstRow[ 'diagnosa' ] ?? '',
        ];

        log_message( 'debug', 'Riwayat data: ' . print_r( $data[ 'pasien' ], true ) );
        return view( 'bidan/detail', $data );
    }

    public function data_rekam( $id, $tgl_daftar ) {
        // Cek apakah parameter $id_pasien diberikan
        if ( !$id ) {
            return redirect()->to( '/BidanController/home' )->with( 'error', 'ID pasien tidak ditemukan.' );
        }

        // Ambil data riwayat kesehatan ( bisa lebih dari satu baris )
        $riwayat = $this->RiwayatKesehatan->getRiwayatByPasienRekam( $id, $tgl_daftar );
        $id_obat = $riwayat[ 0 ][ 'id_obat' ];
        $obat = $this->obatModel->where( 'id_obat', $id_obat )->first();

        // Jika tidak ada data sama sekali
        if ( empty( $riwayat[ 0 ][ 'nm_user' ] ) ) {
            return redirect()->to( '/BidanController/home' )->with( 'error', 'Data pengguna tidak ditemukan.' );
        }

        // Ambil baris pertama untuk menampilkan informasi pasien di form
        $firstRow  = $riwayat[ 0 ];
        $obatRow = isset( $obat[ 0 ] ) ? $obat[ 0 ] : null;
        // Atau jika Anda punya tabel pasien terpisah, silakan ambil dari model pasien
        // Siapkan data untuk view
        $data = [
            'riwayat'    => $riwayat,
            // Data 'pasien' singkat dari baris pertama ( kalau memang join-nya sudah ada )
            'pasien' => [
                'id_pasien'   => $firstRow[ 'id_pasien' ] ?? '',
                'nm_pasien'   => $firstRow[ 'nm_pasien' ] ?? '',
                'tgl_daftar'  => $firstRow[ 'tgl_daftar' ] ?? '',
                'no_antrian'  => $firstRow[ 'no_antrian' ] ?? '',
                'diagnosa'  => $firstRow[ 'diagnosa' ] ?? '',
            ],
            'obat' => [
                'nm_obat'   => $obatRow[ 'nm_obat' ] ?? '',
                'harga'   => $obatRow[ 'harga' ] ?? '',
            ],
            'diagnosa' => $firstRow[ 'diagnosa' ] ?? '',
        ];
        // Tampilkan view
        return view( 'transaksi/bayar', $data );
    }

    // Menampilkan form pemeriksaan

    public function create( $idPasien ) {
        // Ambil data pasien berdasarkan ID
        $pasien = $this->BidanModel->setTablePasien()->where( 'id_pasien', $idPasien )->first();
        $id_user = session( 'id_user' );
        $user = $this->UserModel->where( 'id_user', $id_user )->first();
        // Pastikan pasien ditemukan
        if ( !$pasien ) {
            return redirect()->back()->with( 'error', 'Data pasien tidak ditemukan.' );
        }
        $riwayat = $this->RiwayatKesehatan->where( 'id_pasien', $idPasien )->findAll();
        // Tambahkan data default untuk form pemeriksaan
        $data[ 'pasien' ] = [
            'tgl_daftar' => date( 'Y-m-d' ), // Tanggal otomatis hari ini
            'id_pasien' => $pasien[ 'id_pasien' ], // ID pasien
            'nm_pasien' => $pasien[ 'nm_pasien' ], // Nama pasien
            'nm_user' => $user[ 'nm_user' ], // Nama pasien
            'keluhan' => $pasien[ 'keluhan' ] ?? '', // Keluhan pasien ( default kosong jika tidak ada )
        ];
        $data[ 'riwayat' ] = $riwayat;

        return view( 'bidan/home', $data );
    }

    // Menyimpan data pemeriksaan baru

    public function store() {
        if ( $this->request->getMethod() === 'post' ) {
            // Validasi input
            $validation = $this->validate( [
                'id_riwayat' => 'required',
                'nm_user' => 'required',
                'id_pasien' => 'required',
                'nm_pasien' => 'required',
                'tgl_daftar' => 'required',
                'keluhan' => 'required',
                'diagnosa' => 'required',
                'tindakan' => 'required',
                'nm_obat' => 'required',
                'jumlah' => 'required',
                'keterangan' => 'required',
            ] );

            if ( !$validation ) {
                return redirect()->back()->withInput()->with( 'errors', $this->validator->getErrors() );
            }
            // Ambil data obat dari database
            $id_obat = $this->request->getPost( 'id_obat' );
            $jumlah = $this->request->getPost( 'jumlah' );
            $obat = $this->obatModel->find( $id_obat );

            if ( !$obat ) {
                return redirect()->back()->with( 'error', 'Data obat tidak ditemukan.' );
            }

            // Periksa apakah stok mencukupi
            if ( $obat[ 'stok' ] < $jumlah ) {
                return redirect()->back()->with( 'error', 'Stok obat tidak mencukupi.' );
            }

            // Kurangi stok obat
            $this->obatModel->update( $id_obat, [
                'stok' => $obat[ 'stok' ] - $jumlah,
            ] );

            // Ambil data bidan ( user ) dari UserModel
            $bidan = $this->UserModel->where( 'role', 'bidan' )->findAll();

            // Persiapan data untuk disimpan
            $data = [
                'id_riwayat' => $this->request->getPost( 'id_riwayat' ),
                'nm_user' => $this->request->getPost( 'nm_user' ),
                'id_pasien' => $this->request->getPost( 'id_pasien' ),
                'nm_pasien' => $this->request->getPost( 'nm_pasien' ),
                'keluhan' => $this->request->getPost( 'keluhan' ),
                'diagnosa' => $this->request->getPost( 'diagnosa' ),
                'tindakan' => implode( ', ', ( array )$this->request->getPost( 'tindakan' ) ),
                'tgl_daftar' => date( 'Y-m-d' ),
                'id_obat' => $this->request->getPost( 'id_obat' ),
                'nm_obat' => $this->request->getPost( 'nm_obat' ),
                'jumlah' => $this->request->getPost( 'jumlah' ),
                'keterangan' => $this->request->getPost( 'keterangan' ),
            ];

            // Debug: Tampilkan data yang akan disimpan
            log_message( 'debug', 'Data yang akan disimpan: ' . print_r( $data, true ) );
            log_message( 'error', 'Error Database: ' . print_r( $this->db->error(), true ) );

            // Coba untuk menyimpan data
            if ( $this->BidanModel->setTableRiwayat()->insert( $data ) ) {
                // Debug: Tampilkan pesan sukses jika penyimpanan berhasil
                log_message( 'debug', 'Data berhasil disimpan.' );
                return redirect()->to( 'bidan/rekam' )->with( 'success', 'Data pemeriksaan berhasil disimpan.' );
            } else {
                // Debug: Tampilkan pesan kesalahan jika penyimpanan gagal
                log_message( 'error', 'Gagal menyimpan data: ' . print_r( $this->BidanModel->errors(), true ) );
                return redirect()->back()->with( 'success', 'Data pemeriksaan berhasil disimpan.' );
            }
        }
    }

    public function report() {
        return view( 'bidan/laporan' );
    }

    public function generatePdfReport( $id_pasien, $tgl_daftar ) {
        $this->RiwayatKesehatanModel = new \App\Models\RiwayatkesehatanModel();
        $this->ObatModel = new \App\Models\ObatModel();

        // Ambil nama user dari session
        $data[ 'nm_user' ] = session()->get( 'nm_user' ) ?? 'apoteker';

        // Ambil data pasien berdasarkan ID dan tanggal
        $data[ 'riwayat' ] = $this->RiwayatKesehatanModel
        ->select( 'riwayat_kesehatan.*, obat.harga' )
        ->join( 'obat', 'riwayat_kesehatan.id_obat = obat.id_obat', 'left' )
        ->where( 'riwayat_kesehatan.id_pasien', $id_pasien )
        ->where( 'riwayat_kesehatan.tgl_daftar', $tgl_daftar )
        ->findAll();

        $data[ 'obat' ] = $this->ObatModel->findAll();

        // Debugging log
        log_message( 'debug', 'Riwayat data: ' . print_r( $data[ 'riwayat' ], true ) );

        if ( empty( $data[ 'riwayat' ] ) ) {
            return redirect()->back()->with( 'error', 'Data tidak ditemukan untuk ID dan tanggal tersebut.' );
        }

        // Load view laporan
        $html = view( 'bidan/laporan', $data );

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set( 'isHtml5ParserEnabled', true );
        $options->set( 'isRemoteEnabled', true );

        $dompdf = new Dompdf( $options );
        $dompdf->loadHtml( $html );
        $dompdf->setPaper( 'A4', 'portrait' );
        $dompdf->render();

        // Output file PDF dengan nama sesuai tanggal
        $filename = "Laporan_Riwayat_{$tgl_daftar}.pdf";
        $dompdf->stream( $filename, [ 'Attachment' => false ] );
    }

    public function logout() {
        // Hapus semua data sesi
        session()->destroy();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to( '/bidan/index' )->with( 'sukses', 'Anda berhasil logout.' );
    }
}
