<?php
require_once __DIR__ . '/../models/SuratModel.php';

class SuratController {
    private $suratModel;

    public function __construct() {
        $this->suratModel = new SuratModel();
    }

    public function addSuratMasuk($nomor_surat, $tanggal, $perihal, $pengirim) {
        if (!$this->suratModel->isNomorSuratExists($nomor_surat, 'masuk')) {
            return $this->suratModel->createSuratMasuk($nomor_surat, $tanggal, $perihal, $pengirim);
        }
        return false; // Nomor surat already exists
    }

    public function addSuratKeluar($nomor_surat, $tanggal, $perihal, $tujuan) {
        if (!$this->suratModel->isNomorSuratExists($nomor_surat, 'keluar')) {
            return $this->suratModel->createSuratKeluar($nomor_surat, $tanggal, $perihal, $tujuan);
        }
        return false; // Nomor surat already exists
    }

    public function getSuratMasuk() {
        return $this->suratModel->getSuratMasuk();
    }

    public function getSuratKeluar() {
        return $this->suratModel->getSuratKeluar();
    }

    public function getTotalSuratMasuk() {
        return $this->suratModel->getTotalSuratMasuk();
    }

    public function getTotalSuratKeluar() {
        return $this->suratModel->getTotalSuratKeluar();
    }
}