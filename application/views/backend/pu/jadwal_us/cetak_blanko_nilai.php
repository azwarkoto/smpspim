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

foreach ($data as $detail) {
    if ($detail->ID_KELAS != $temp_kelas) {
        $temp_kelas = $detail->ID_KELAS;
        
        $pdf->AddPage("P", array(210 / 2, 297));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'BLANKO NILAI CAWU ' . $this->session->userdata('ID_CAWU_ACTIVE') . ' TA ' . $this->session->userdata('NAMA_TA_ACTIVE'));
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, 'KELAS: ' . $detail->NAMA_KELAS);
        $pdf->Ln();

        $pdf->Cell(0, 5, 'WALI KELAS: ' . $this->cetak->nama_peg_print($detail));
        $pdf->Ln();

        $pdf->Cell(0, 5, 'MAPEL: ...............................................');
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(7, 5, 'NO', 1, 0, 'C');
        $pdf->Cell(60, 5, 'NAMA', 1, 0, 'C');
        $pdf->Cell(20, 5, 'NILAI', 1, 0, 'C');
        $pdf->Ln();
        
        $pdf->SetFont('Arial', '', 9);
    }

    $pdf->Cell(7, 5, $detail->NO_ABSEN_AS, 1);
    $pdf->Cell(60, 5, $detail->NAMA_SISWA, 1);
    $pdf->Cell(20, 5, '', 1);
    $pdf->Ln();
}

$pdf->Output();
