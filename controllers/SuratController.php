<?php
require_once __DIR__ . '/../models/SuratModel.php';

class SuratController {
    private $suratModel;
    private $db;

    public function __construct() {
        $this->suratModel = new SuratModel();
        $this->db = Database::getInstance()->getConnection();
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

    public function getSuratKeluar($search = null) {
        $query = "SELECT * FROM surat_keluar";
        if ($search) {
            $query .= " WHERE perihal LIKE :search OR tujuan LIKE :search";
        }
        $query .= " ORDER BY tanggal DESC";
        
        $stmt = $this->db->prepare($query);
        if ($search) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteSuratMasuk($id) {
        return $this->suratModel->deleteSuratMasuk($id);
    }

    public function deleteSuratKeluar($id) {
        return $this->suratModel->deleteSuratKeluar($id);
    }

    public function getTotalSuratMasuk() {
        return $this->suratModel->getTotalSuratMasuk();
    }

    public function getTotalSuratKeluar() {
        return $this->suratModel->getTotalSuratKeluar();
    }
}