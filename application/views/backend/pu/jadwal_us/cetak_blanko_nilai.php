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

$temp_kelas = NULL;
$f4 = $this->pengaturan->getUkuranF4();
$width = $f4[0] / 2;
$height = $f4[1];

foreach ($data as $detail) {
    if ($detail->ID_KELAS != $temp_kelas) {
        if ($temp_kelas != NULL) {
            $pdf->Ln(3);
            $pdf->Cell(30);
            $pdf->Cell(0, 5, '.......................,..............................');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(0, 10, 'Pengampu mapel,');
            $pdf->Ln(14);
            $pdf->Cell(30);
            $pdf->Cell(0, 5, '.............................');
        }

        $temp_kelas = $detail->ID_KELAS;

        $pdf->SetLeftMargin(5);
        $pdf->AddPage("P", array($width, $height));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'BLANKO NILAI CAWU ' . $this->session->userdata('ID_CAWU_ACTIVE') . ' TA ' . $this->session->userdata('NAMA_TA_ACTIVE'));
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, 'KELAS: ' . $detail->NAMA_KELAS);
        $pdf->Ln();

        $pdf->Cell(0, 5, 'WALI KELAS: ' . $this->cetak->nama_peg_print($detail));
        $pdf->Ln();

//        $pdf->Cell(0, 10, 'MAPEL: ...............................................');
//        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(7, 5, 'NO', 1, 0, 'C');
        $pdf->Cell(23, 5, 'NIS', 1, 0, 'C');
        $pdf->Cell(42, 5, 'NAMA', 1, 0, 'C');
        $pdf->Cell(12, 5, 'MAPEL', 1, 0, 'C');
        $pdf->Cell(12, 5, 'MAPEL', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 9);
    }

    $pdf->Cell(7, 6.5, $detail->NO_ABSEN_AS, 1);
    $pdf->Cell(23, 6.5, $detail->NIS_SISWA, 1);
    $pdf->Cell(42, 6.5, $this->pdf_handler->cut_text($pdf, $detail->NAMA_SISWA, 42), 1);
    $pdf->Cell(12, 6.5, '', 1);
    $pdf->Cell(12, 6.5, '', 1);
    $pdf->Ln();
}
$pdf->Ln(3);
$pdf->Cell(30);
$pdf->Cell(0, 5, '.......................,..............................');
$pdf->Ln();
$pdf->Cell(30);
$pdf->Cell(0, 10, 'Pengampu mapel,');
$pdf->Ln(14);
$pdf->Cell(30);
$pdf->Cell(0, 5, '.............................');

$pdf->Output();
