<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
  $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
 * 
 */

$pdf = $this->fpdf;

$temp_kelas = null;

foreach ($data_tindakan as $data) {
    $alamat_siswa = $data['ALAMAT_SISWA'] . ', Kec. ' . $data['NAMA_KEC'] . ', ' . $data['NAMA_KAB'] . ', Prov ' . $data['NAMA_PROV'];

    $pdf->AddPage("P", "A5");
//	$pdf->SetMargins(6, 0);
    $pdf->SetAutoPageBreak(true, 0);

    $pdf = $this->cetak->header_panitia_a5($pdf, $nama_panitia);

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'U', 18);
    $pdf->Cell(0, 5, 'SURAT PERINGATAN', 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Nomor: ' . $data['nomor_surat'], 0, 0, 'C');
    $pdf->Ln(12);

    $pdf->Cell(12);
    $pdf->Cell(0, 5, 'Kepada Saudara: ');
    $pdf->Ln(8);

    $pdf->Cell(12);
    $pdf->Cell(20, 5, 'Nama');
    $pdf->Cell(0, 5, ': ' . $data['NAMA_SISWA']);
    $pdf->Ln(6);

    $pdf->Cell(12);
    $pdf->Cell(20, 5, 'Kelas');
    $pdf->Cell(0, 5, ': ' . (($data['NAMA_KELAS'] == NULL) ? 'Belum mempunyai kelas' : $data['NAMA_KELAS']));
    $pdf->Ln(6);

    $pdf->Cell(12);
    $pdf->Cell(20, 5, 'Alamat');
    $pdf->MultiCell(0, 5, ': ' . $alamat_siswa);
    $pdf->Ln(1);

    $pdf->Cell(12);
    $pdf->Cell(20, 5, 'Domisili');
    $pdf->MultiCell(0, 5, ': ' . (($data['PONDOK_SISWA'] == NULL || $data['PONDOK_SISWA'] == 1) ? $alamat_siswa : ($data['NAMA_PONDOK_MPS'] . ' ' . $data['ALAMAT_MPS'])));
    $pdf->Ln(4);

    $pdf->MultiCell(0, 5, 'Diberikan PERINGATAN sesuai dengan Peraturan Pelengkap Tata Tertib Siswa Perguruan Islam Mathali\'ul Falah Tahun 2010 Bab III tentang Pembinaan dan Sanksi Pasal 11 huruf b yang berbunyi: "Peringatan tertulis jika akumulasi skor pelanggaran antara ' . $POIN_MIN . ' hingga ' . $POIN_MAKS . ' poin" dikarenakan telah memiliki akumulasi poin ' . $data['JUMLAH_POIN_KSH'] . '. Adapun data pelanggaran sebagaimana terlampir.');
    $pdf->Ln(4);

    $pdf->Cell(12);
    $pdf->MultiCell(0, 5, 'Demikian untuk menjadi perhatian.');
    $pdf->Ln(8);

    $pdf->Cell(70);
    $pdf->Cell(0, 5, $this->pengaturan->getDesa() . ', ' . $this->date_format->to_print_text($data['tanggal']));
    $pdf->Ln();

    $pdf->Cell(0, 5, 'Mengetahui');
    $pdf->Ln();

    $pdf->Cell(70, 5, 'Wali Kelas ' . $data['NAMA_KELAS']);
    $pdf->Cell(0, 5, 'Ketua');
    $posisi_y = $pdf->GetY();
    $pdf->Ln(18);
    
    $pdf->Image(base_url('files/aplikasi/tt_ketua_komdis.png'), 80, $posisi_y - 5, 24, 24, '', '');

    $pdf->Cell(70, 5, $this->cetak->nama_peg_print_short($data['WALI_KELAS']));
    $pdf->Cell(0, 5, $this->cetak->nama_peg_print_short($data['NAMA_TANGGUNGJAWAB']));

    // ====================================================================================================

    $siswa = $data['DETAIL_PELANGGARAN']['siswa'];
    $pelanggaran = $data['DETAIL_PELANGGARAN']['pelanggaran'];

    $pdf->AddPage("P", "A5");
//	$pdf->SetMargins(6, 0);
    $pdf->SetAutoPageBreak(true, 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'DETAIL PELANGGARAN SISWA', 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 5, 'KOMISI DISIPLIN SISWA', 0, 0, 'C');
    $pdf->Ln(8);

    $pdf->SetFont('Arial', '', 7);

//$pdf->Cell(20, 5, 'T A');
//$pdf->Cell(100, 5, ': ' . $siswa->NAMA_TA);
//$pdf->Cell(20, 5, 'Catur Wulan');
//$pdf->Cell(0, 5, ': ' . $siswa->NAMA_CAWU);
//$pdf->Ln();

    $pdf->Cell(15, 4, 'Nama');
    $pdf->Cell(100, 5, ': ' . $siswa['NIS_SISWA'] . ' - ' . $siswa['NAMA_SISWA']);
    $pdf->Cell(20, 5, 'Telp.');
    $pdf->Cell(0, 5, ': ' . (!isset($siswa['NOHP_SISWA']) ? '-' : $siswa['NOHP_SISWA']));
    $pdf->Ln();

    $pdf->Cell(15, 4, 'Domisili');
    $pdf->Cell(100, 4, ': ' . $this->pdf_handler->cut_text($pdf, ($siswa['PONDOK_SISWA'] == NULL || $siswa['PONDOK_SISWA'] == 1) ? 'Belum Mondok' : $siswa['NAMA_PONDOK_MPS'] . ' ' . $siswa['ALAMAT_MPS'], 100));
    $pdf->Cell(15, 4, 'Kelas');
    $pdf->Cell(0, 4, ': ' . $siswa['NAMA_KELAS']);
    $pdf->Ln();

    $pdf->Cell(15, 4, 'Alamat');
    $pdf->Cell(100, 4, ': ' . $this->pdf_handler->cut_text($pdf, $siswa['ALAMAT_SISWA'] . ', Kec. ' . $siswa['NAMA_KEC'] . ', ' . str_replace('kabupaten', 'Kab.', strtolower($siswa['NAMA_KAB'])), 100));
    $pdf->Cell(15, 4, 'Surat');
    $pdf->Cell(0, 4, ': ' . ($siswa['NAMA_KJT'] == NULL ? '-' : $siswa['NAMA_KJT']));
    $pdf->Ln();

    $pdf->Cell(15, 4, 'Wali Santri');
    $pdf->Cell(100, 4, ': ' . $this->cetak->nama_wali_siswa($siswa));
    $pdf->Cell(15, 4, 'Jumlah Poin');
    $pdf->Cell(0, 4, ': ' . $siswa['JUMLAH_POIN_KSH']);
    $pdf->Ln();

    $pdf->Cell(15, 4, 'Wali Kelas');
    $pdf->Cell(100, 4, ': ' . $this->cetak->nama_peg_print_title($siswa['GELAR_AWAL_WALI_KELAS'], $siswa['WALI_KELAS'], $siswa['GELAR_AKHIR_WALI_KELAS']).' ('.(!isset($siswa['NOMOR_HP_WALI_KELAS']) ? '-' : $siswa['NOMOR_HP_WALI_KELAS']).')');
    $pdf->Cell(15, 4, 'Jumlah Lari');
    $pdf->Cell(0, 4, ': ' . $siswa['JUMLAH_LARI_KSH']);
    $pdf->Ln(5);
    
    $data_header = array(
        array('align' => 'C', 'width' => 7, 'height' => 4, 'text' => 'No'),
        array('align' => 'C', 'width' => 24, 'text' => 'Tanggal Memasukan Data'),
        array('align' => 'C', 'width' => 60, 'text' => 'Pelanggaran'),
        array('align' => 'C', 'width' => 27, 'text' => 'Tanggal Pelanggaran'),
        array('align' => 'C', 'width' => 10, 'text' => 'Poin')
    );

    $pdf->SetFont('Arial', 'B', 7);
    $pdf = $this->pdf_handler->wrap_row_table($pdf, $data_header);

    $pdf->SetFont('Arial', '', 7);
    $i = 1;
    foreach ($pelanggaran as $detail) {
        $data_header = array(
            array('align' => 'C', 'width' => 7, 'height' => 5, 'text' => $i++),
            array('align' => 'L', 'width' => 24, 'text' => $this->date_format->get_day($detail['TANGGAL_INPUT']) . ', ' . $this->date_format->to_print_short($detail['TANGGAL_INPUT'])),
            array('align' => 'L', 'width' => 60, 'text' => $detail['NAMA_KJP']),
            array('align' => 'L', 'width' => 27, 'text' => $this->date_format->get_day($detail['TANGGAL_KS']) . ', ' . $this->date_format->to_print_short($detail['TANGGAL_KS'])),
            array('align' => 'C', 'width' => 10, 'text' => $detail['POIN_KJP'])
        );

        $pdf = $this->pdf_handler->wrap_row_table($pdf, $data_header);
    }
    $pdf->SetFont('Arial', 'I', 6);
    $pdf->Cell(0, 5, 'Dicetak tanggal: ' . $this->date_format->to_print_short(date('Y-m-d')), 0, 0, 'R');
}

$pdf->Output();
