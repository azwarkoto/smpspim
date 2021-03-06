<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
  $this->CoreFonts = array('Arial', 'helvetica', 'times', 'symbol', 'zapfdingbats');
 * 
 */

$pdf = $this->fpdf;
$f4 = $this->pengaturan->getUkuranF4();
$width = $f4[0];
$height = $f4[1] / 2;

foreach ($SISWA as $DETAIL) {
    $DATA_SISWA = $DETAIL['DETAIL'];
    $DATA_KITAB = $DETAIL['KITAB'];

    $pdf->SetMargins(10, 6);
    $pdf->AddPage("L", array($width, $height));
    $pdf->SetAutoPageBreak(true, 0);
    
    $posisi_x = 175;
    $posisi_y = 7;

    $pdf->Image(base_url($this->pengaturan->getLogo()), 15, 6, 20, 20, '', '');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 5, 'PANITIA PELAKSANAAN DAN PENYEMAAN HAFALAN', 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 5, strtoupper($this->pengaturan->getNamaLembaga()), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, strtoupper($this->pengaturan->getDesa() . ' - ' . $this->pengaturan->getKecamatan() . ' - ' . $this->pengaturan->getKabupaten() . ' ' . $this->pengaturan->getKodepos()), 0, 0, 'C');
    $pdf->Ln();

    // $pdf->Cell(0, 5, 'TELP. '.$this->pengaturan->getTelp().' FAX. '.$this->pengaturan->getFax(), 0, 0, 'C');
    // $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, 'BLANKO PENDAFTARAN SEMAAN HAFALAN', 0, 0, 'C');
    $pdf->Ln(8);

    // $pdf->Cell(0, 5, 'TAHUN AJARAN '.$DETAIL['TA'], 0, 0, 'C');
    // $pdf->Ln(8);

    if (file_exists('files/siswa/' . $DATA_SISWA->NIS_SISWA . '.jpg'))
        $pdf->Image(base_url('files/siswa/' . $DATA_SISWA->NIS_SISWA . '.jpg'), 15, 30, 20, 26.7);
    elseif (file_exists('files/siswa/' . $DATA_SISWA->ID_SISWA . '.png'))
        $pdf->Image(base_url('files/siswa/' . $DATA_SISWA->ID_SISWA . '.png'), 15, 30, 20, 26.7);
    else
        $pdf->Image(base_url('files/no_image.jpg'), 13, 30, 28, 28);

    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(33);
    $pdf->Cell(20, 5, 'Nama', 0, 0, 'L');
    $pdf->Cell(0, 5, ': ' . $DATA_SISWA->NAMA_SISWA, 0, 0, 'L');
    $pdf->Ln();

    $pdf->Cell(33);
    $pdf->Cell(20, 5, 'N I S', 0, 0, 'L');
    $pdf->Cell(0, 5, ': ' . $DATA_SISWA->NIS_SISWA, 0, 0, 'L');
    $pdf->Ln();

    $pdf->Cell(33);
    $pdf->Cell(20, 5, 'Kelas', 0, 0, 'L');
    $pdf->Cell(0, 5, ': ' . $DETAIL['KELAS'], 0, 0, 'L');
    $pdf->Ln();

    $pdf->Cell(33);
    $pdf->Cell(20, 5, 'No. Absen', 0, 0, 'L');
    $pdf->Cell(0, 5, ': ' . $DATA_SISWA->NO_ABSEN_AS, 0, 0, 'L');
    $pdf->Ln();

    $pdf->Cell(33);
    $pdf->MultiCell(0, 5, 'Setelah kami lakukan pembimbingan hafalan, maka bersama ini kami daftarkan siswa tersebut di atas untuk dilakukan penyemaan oleh penyemak P3H sebagaimana ketentuan yang berlaku:');
    $pdf->Ln(1);

    for ($i = 0; $i <= 12; $i++) {
        $pdf->Cell(7, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'No' : $i, 1, 0, 'C');
        $pdf->Cell(17, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Tanggal' : '', 1, 0, 'C');
        $pdf->Cell(35, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Nama Kitab' : '', 1, 0, 'C');
        $pdf->Cell(45, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Uraian' : '', 1, 0, 'C');
        $pdf->Cell(28, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Ttd Wali Kelas' : '', 1, 0, 'C');
        $pdf->Cell(27, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Keterangan' : '', 1, 0, 'C');
        $pdf->Cell(39, ($i == 0) ? 5 : 6.5, ($i == 0) ? 'Nama & Ttd Penyemak' : '', 1, 0, 'C');
        $pdf->Ln();
    }

    $pdf->Ln(2);

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(20, 5, 'Catatan :', 0, 0, 'L');
    $pdf->Cell(0, 5, '1. Blanko langsung dimasukan dalam kotak pendaftaran yang tersedia dalam ruang guru', 0, 0, 'L');
    $pdf->Ln();

    $pdf->Cell(20);
    $pdf->Cell(0, 5, '2. Pendaftaran ditutup sehari sebelum pelaksanaan penyemaan hafalan', 0, 0, 'L');
    $pdf->Ln();

    $pdf->SetLineWidth(0.50);
    $pdf->Line(11, 27, 207, 27);
    $pdf->SetLineWidth(0.30);
    $pdf->Line(11, 28, 207, 28);
    $pdf->Image(base_url('files/aplikasi/p3h.png'), $posisi_x, $posisi_y, 30, 30);
}

$pdf->Output();
