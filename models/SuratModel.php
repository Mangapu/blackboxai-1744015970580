<?php
require_once __DIR__ . '/Database.php';

class SuratModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Surat Masuk Methods
    public function deleteSuratMasuk($id) {
        $stmt = $this->db->prepare("DELETE FROM surat_masuk WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createSuratMasuk($nomor_surat, $tanggal, $perihal, $pengirim) {
        $stmt = $this->db->prepare("INSERT INTO surat_masuk (nomor_surat, tanggal, perihal, pengirim) VALUES (:nomor, :tanggal, :perihal, :pengirim)");
        $stmt->bindParam(':nomor', $nomor_surat);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':perihal', $perihal);
        $stmt->bindParam(':pengirim', $pengirim);
        return $stmt->execute();
    }

    public function getSuratMasuk($id = null) {
        if ($id) {
            $stmt = $this->db->prepare("SELECT * FROM surat_masuk WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM surat_masuk ORDER BY tanggal DESC");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Surat Keluar Methods
    public function createSuratKeluar($nomor_surat, $tanggal, $perihal, $tujuan) {
        $stmt = $this->db->prepare("INSERT INTO surat_keluar (nomor_surat, tanggal, perihal, tujuan) VALUES (:nomor, :tanggal, :perihal, :tujuan)");
        $stmt->bindParam(':nomor', $nomor_surat);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':perihal', $perihal);
        $stmt->bindParam(':tujuan', $tujuan);
        return $stmt->execute();
    }

    public function getSuratKeluar($id = null) {
        if ($id) {
            $stmt = $this->db->prepare("SELECT * FROM surat_keluar WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM surat_keluar ORDER BY tanggal DESC");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Statistics Methods
    public function getTotalSuratMasuk() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM surat_masuk");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalSuratKeluar() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM surat_keluar");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Check for duplicate nomor_surat
    public function isNomorSuratExists($nomor_surat, $type = 'masuk') {
        $table = ($type === 'masuk') ? 'surat_masuk' : 'surat_keluar';
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE nomor_surat = :nomor");
        $stmt->bindParam(':nomor', $nomor_surat);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}