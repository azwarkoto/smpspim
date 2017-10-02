<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
  $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
 * 
 */
$CI = & get_instance();

$CI->load->model(array(
    'departemen_model' => 'departemen',
    'siswa_model' => 'siswa',
));

$jumlah_perbaris = $this->pengaturan->getJumlahSiswaPerbaris();

// PENGATURAN FOTO SISWA
$start_x = 19;
$start_y = 31;
$margin_left = 38;
$margin_top = 35;
$width_photo = 25;
$height_photo = 23;
$width_box = 33;

$size_font = 12;

$pdf = $this->fpdf;

foreach ($data as $detail) {
    $tanggal = $detail['TANGGAL'];
    $denah = json_decode($detail['DENAH'], TRUE);

    $pdf->AddPage("L", $this->pengaturan->getUkuranF4());

    for ($i = 0; $i < 300; $i++) {
        $pdf->Line(0, $i, 350, $i);
    }

    $pdf->SetY(100);
    $pdf->SetFont('Arial', 'B', 40);
    $pdf->Cell(0, 5, $tanggal, 0, 0, 'C');
    $pdf->Ln();

    foreach ($denah as $jk => $data_denah) {
        if ($jk == 'L')
            $jk = 'BANIN';
        else
            $jk = 'BANAT';

        $pdf->AddPage("L", $this->pengaturan->getUkuranF4());

        for ($i = 0; $i < 300; $i++) {
            $pdf->Line(0, $i, 350, $i);
        }

        $pdf->SetY(100);
        $pdf->SetFont('Arial', 'B', 40);
        $pdf->Cell(0, 5, $tanggal . '  >>> ' . $jk, 0, 0, 'C');
        $pdf->Ln();

        $jumlah_perbaris = $data_denah['JUMLAH_PERBARIS'];

        $temp_last_id = array_fill(0, count($data_denah['JENJANG']), 0);

        foreach ($data_denah['JENJANG'] as $dept) {
            $data_denah['KODE_JENJANG'][] = $CI->departemen->get_id_by_jenjang($dept);
        }

        foreach ($data_denah['DENAH'] as $ruang => $value) {
            $jumlah_peruang = $data_denah['RUANG'][$ruang]['KAPASITAS_UJIAN_RUANG'];

            $pdf->AddPage("L", $this->pengaturan->getUkuranF4());
            $pdf->SetAutoPageBreak(true, 0);

            $pdf->SetFont('Arial', 'B', $size_font + 2);
            $pdf->Cell(0, 5, 'DENAH UJIAN SEKOLAH ' . $jk, 0, 0, 'C');
            $pdf->Ln();

            $pdf->Cell(0, 5, strtoupper($this->pengaturan->getNamaLembaga() . ' (' . $this->pengaturan->getNamaLembagaSingk() . ')'), 0, 0, 'C');
            $pdf->Ln();

            $pdf->SetFont('Arial', 'B', $size_font);
            $pdf->Cell(0, 5, 'TAHUN AJARAN ' . $this->session->userdata('NAMA_TA_ACTIVE') . ' CAWU ' . $this->session->userdata('ID_CAWU_ACTIVE'), 0, 0, 'C');
            $pdf->Ln();

            $pdf->Cell(5);
            $pdf->Cell(214, 5, 'RUANG UJIAN: ' . $data_denah["RUANG"][$ruang]['KODE_RUANG'] . ' - ' . $data_denah["RUANG"][$ruang]['NAMA_RUANG'], 0, 0, 'L');
            $pdf->Cell(0, 5, 'TANGGAL: ' . $this->date_format->to_print($tanggal), 0, 0, 'C');
            $pdf->Ln();

            $pdf->SetFont('Arial', '', $size_font - 2);

            $posisi_y = 0;
            for ($i = 0; $i < $jumlah_peruang; $i++) {
                $pdf->Cell(5);
                $pdf->Cell($width_box, 25, $i + 1, 'RLT', 0, 'C');

                $posisi_x = 0;
                if ((($i + 1) % $jumlah_perbaris) == 0) {
                    $pdf->Ln();

                    $baris_ke = ($i + 1) / $jumlah_perbaris - 1;

                    if ($baris_ke > 0)
                        $posisi_y += $margin_top;
                    else
                        $posisi_y += $start_y;

                    $data_siswa = array();
                    for ($x = ($i + 1 - $jumlah_perbaris); $x <= $i; $x++) {
                        $kolom_ke = $x - ($jumlah_perbaris * $baris_ke);

                        if ($kolom_ke > 0)
                            $posisi_x += $margin_left;
                        else
                            $posisi_x += $start_x;

                        if (isset($data_denah['DENAH'][$ruang][$x])) {
                            $id_tingkat = $data_denah['DENAH'][$ruang][$x];
                            $id_jenjang = $data_denah['JENJANG'][$id_tingkat];
                            $id_siswa = $data_denah['DATA_SISWA_RANDOM'][$id_tingkat][$temp_last_id[$id_tingkat]]['ID_SISWA'];
                            $data_siswa[$x] = $CI->siswa->get_by_id_simple($id_siswa);
                            $temp_last_id[$id_tingkat] ++;

//                            $nama_siswa = $this->cetak->nama_pendek_3($data_siswa[$x]->NAMA_SISWA);
                            $nama_siswa = $data_siswa[$x]->NAMA_SISWA;

                            $pdf->Cell(5);
//                            $pdf->Cell($width_box, 4, $posisi_x.', '.$posisi_y, 'RL', 0, 'C');
                            $pdf->SetFont('Arial', '', $size_font - 4);
                            $pdf->Cell($width_box, 4, $this->pdf_handler->cut_text($pdf, $nama_siswa, $width_box), 'RL', 0, 'C');
                            $pdf->SetFont('Arial', '', $size_font - 2);

//                            if (file_exists('files/siswa/' . $data_siswa[$x]->NIS_SISWA . '.jpg'))
//                                $pdf->Image(base_url('files/siswa/' . $data_siswa[$x]->NIS_SISWA . '.jpg'), $posisi_x, $posisi_y, $width_photo - 7, 75, $height_photo, '', '');
//                            elseif (file_exists('files/siswa/' . $data_siswa[$x]->ID_SISWA . '.png'))
//                                $pdf->Image(base_url('files/siswa/' . $data_siswa[$x]->ID_SISWA . '.png'), $posisi_x, $posisi_y, $width_photo - 7, 75, $height_photo, '', '');
//                            else
                                $pdf->Image(base_url('files/no_image.jpg'), $posisi_x, $posisi_y, $width_photo, $height_photo, '', '');
                        } else {
                            $pdf->Cell(5);
                            $pdf->Cell($width_box, 4, '', 'RL', 0, 'C');
                        }
                    }

                    $pdf->Ln();

                    for ($x = ($i + 1 - $jumlah_perbaris); $x <= $i; $x++) {
                        if (isset($data_denah['DENAH'][$ruang][$x])) {
                            $id_tingkat = $data_denah['DENAH'][$ruang][$x];

                            $pdf->Cell(5);
                            $pdf->Cell($width_box, 4, $data_denah['KODE_JENJANG'][$id_tingkat] . ' KELAS: ' . $data_siswa[$x]->MASUK_TINGKAT_SISWA, 'RLB', 0, 'C');
                        } else {
                            $pdf->Cell(5);
                            $pdf->Cell($width_box, 4, '', 'RLB', 0, 'C');
                        }
                    }

                    $pdf->Ln(6);
                }
            }

//            $pdf->SetFont('Arial', '', $size_font);
//            $pdf->Cell(180);
//            $pdf->Cell(0, 5, 'Ketua Panitia Ujian,', 0, 0, 'C');
//            $pdf->Ln(15);
//
//            $pdf->SetFont('Arial', 'BU', $size_font);
//            $pdf->Cell(180);
//            $pdf->Cell(0, 5, $ketua->NAMA_PEG, 0, 0, 'C');
//            $pdf->Ln();
//
//            $pdf->SetFont('Arial', '', $size_font);
//            $pdf->Cell(180);
//            $pdf->Cell(0, 5, 'NIP. '.$ketua->NIP_PEG, 0, 0, 'C');
        }
    }
}

$pdf->Output();
