<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sekolah
 *
 * @author rohmad
 */
class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'siswa_model' => 'siswa',
            'suku_model' => 'suku',
            'agama_model' => 'agama',
            'kondisi_model' => 'kondisi',
            'jk_model' => 'jk',
            'Kewarganegaraan_model' => 'warga',
            'darah_model' => 'darah',
            'kecamatan_model' => 'kecamatan',
            'tinggal_model' => 'tinggal',
            'asal_sekolah_model' => 'asal_sekolah',
            'ortu_hidup_model' => 'ortu_hidup',
            'jenjang_pendidikan_model' => 'pendidikan',
            'pekerjaan_model' => 'pekerjaan',
            'hubungan_model' => 'hubungan',
            'penghasilan_model' => 'penghasilan',
            'tagihan_model' => 'tagihan',
            'detail_tagihan_model' => 'detail_tagihan',
            'assign_tagihan_model' => 'assign_tagihan',
            'jenjang_sekolah_model' => 'jenjang_sekolah',
        ));
        $this->load->library('denah_handler');
        $this->auth->validation(array(2, 7));
    }

    public function index() {
        $this->generate->backend_view('akademik/siswa/index');
    }

    public function ajax_list() {
        $this->generate->set_header_JSON();

        $id_datatables = 'datatable1';
        $list = $this->siswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->NIS_SISWA;
            $row[] = $item->NAMA_SISWA;
            $row[] = $item->ANGKATAN_SISWA;
            $row[] = $item->JK_SISWA;
            $row[] = $item->TEMPAT_LAHIR_SISWA;
            $row[] = $item->TANGGAL_LAHIR_SISWA;
            $row[] = $item->ALAMAT_SISWA;
            $row[] = $item->NAMA_KEC;
            $row[] = $item->NAMA_KAB;
            $row[] = $item->NAMA_PROV;

            if ($item->KELAS_AS == NULL)
                $surat_keterangan_aktif = '';
            else
                $surat_keterangan_aktif = '<li><a href="javascript:void()" title="Surat Keterangan Aktif" onclick="surat_keterangan_aktif(\'' . $item->ID_SISWA . '\')"><i class="fa fa-print"></i>&nbsp;&nbsp;Surat Keterangan Aktif</a></li>';

            $row[] = '
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">AKSI&nbsp;&nbsp;<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void()" title="Ubah Data" onclick="update_data(\'' . $item->ID_SISWA . '\')"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Ubah Data</a></li>
                        <li><a href="javascript:void()" title="Lihat Data" onclick="view_data(\'' . $item->ID_SISWA . '\')"><i class="fa fa-eye"></i>&nbsp;&nbsp;Lihat Data</a></li>
                        <li><a href="javascript:void()" title="Foto Siswa" onclick="view_photo(\'' . $item->ID_SISWA . '\')"><i class="fa fa-file-photo-o "></i>&nbsp;&nbsp;Foto Siswa</a></li>
                        <li><a href="javascript:void()" title="Kartu Siswa" onclick="kartu_pelajar(\'' . $item->ID_SISWA . '\')"><i class="fa fa-print"></i>&nbsp;&nbsp;Kartu Siswa</a></li>
                        ' . $surat_keterangan_aktif . '
                    </ul>
                </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->siswa->count_all(),
            "recordsFiltered" => $this->siswa->count_filtered(),
            "data" => $data,
        );

        $this->generate->output_JSON($output);
    }

    public function view_data() {
        $this->generate->set_header_JSON();

        $data = $this->siswa->get_by_id($this->input->post('ID_SISWA'));

        $this->generate->output_JSON($data);
    }

    public function view_photo() {
        $this->generate->set_header_JSON();

        $data = $this->siswa->get_by_id($this->input->post('ID_SISWA'));

        if ($data->FOTO_SISWA == NULL)
            $status = FALSE;
        else
            $status = TRUE;

        $this->generate->output_JSON(array(
            'status' => $status,
            'data' => array(
                'FOTO_SISWA' => $data->FOTO_SISWA,
                'NAMA_SISWA' => $data->NAMA_SISWA,
            )
        ));
    }

    public function kartu($ID_SISWA) {
        $data = $this->siswa->get_by_id($ID_SISWA);

        $this->generate->backend_view('akademik/siswa/kartu', $data);
    }

    public function surat_keterangan_aktif($ID_SISWA) {
        $data['siswa'] = $this->siswa->get_by_id($ID_SISWA);

        $this->load->view('backend/akademik/siswa/cetak_keterangan_aktif', $data);
    }

    public function cetak_kartu($ID_SISWA = NULL) {
        $data['siswa'] = $this->siswa->get_data_kartu($ID_SISWA);
        
        $this->load->view('backend/akademik/siswa/cetak_kartu', $data);
    }

    public function cetak_kartu_kelas($ID_KELAS) {
        if($ID_KELAS == 0) $ID_KELAS = NULL;
        $data['siswa'] = $this->siswa->get_data_kartu(NULL, $ID_KELAS);
        
        $this->load->view('backend/akademik/siswa/cetak_kartu', $data);
    }

    public function auto_complete() {
        $this->generate->set_header_JSON();

        $data = $this->siswa->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function form($ID_SISWA) {
        $data['data'] = $this->siswa->get_by_id($ID_SISWA);

        $this->generate->backend_view('akademik/siswa/form', $data);
    }

    private function selection_form($data) {
        if(isset($data['TANGGAL_LAHIR_SISWA'])) $data['TANGGAL_LAHIR_SISWA'] = $this->date_format->to_store_db($data['TANGGAL_LAHIR_SISWA']);
        if(isset($data['AYAH_TANGGAL_LAHIR_SISWA'])) $data['AYAH_TANGGAL_LAHIR_SISWA'] = $this->date_format->to_store_db($data['AYAH_TANGGAL_LAHIR_SISWA']);
        if(isset($data['IBU_TANGGAL_LAHIR_SISWA'])) $data['TANGGAL_LAHIR_SISWA'] = $this->date_format->to_store_db($data['IBU_TANGGAL_LAHIR_SISWA']);
        if(isset($data['TANGGAL_IJASAH_SISWA'])) $data['TANGGAL_LAHIR_SISWA'] = $this->date_format->to_store_db($data['TANGGAL_IJASAH_SISWA']);
        unset($data['validasi']);
        foreach ($data as $key => $value) {
            if ($value == '')
                unset($data[$key]);
        }

        return $data;
    }

    public function ajax_update() {
        $this->generate->set_header_JSON();
        $this->generate->cek_validation_simple('edit');

        $data = $this->selection_form($this->input->post());

        $where = array(
            'ID_SISWA' => $data['ID_SISWA']
        );
        unset($data['ID_SISWA']);

        $affected_row = $this->siswa->update($where, $data);

        $this->generate->output_JSON(array("status" => 1));
    }

    public function save_take_photo() {
        $this->generate->set_header_JSON();

        $ID_SISWA = $this->input->post('ID_SISWA');
        $data_image = $this->input->post('TAKE_FOTO_SISWA');

        $where = array(
            'ID_SISWA' => $ID_SISWA
        );
        $data = array(
            'FOTO_SISWA' => NULL
        );
        $this->siswa->update($where, $data);
        $status = $this->save_photobooth($ID_SISWA, $data_image);

        $this->generate->output_JSON(array("status" => $status, 'msg' => ''));
    }

    private function save_photobooth($ID_SISWA, $data_image) {
        list($type, $data_image) = explode(';', $data_image);
        list(, $data_image) = explode(',', $data_image);
        $data_image = base64_decode($data_image);
        $name_file = 'files/siswa/' . $ID_SISWA . '.png';

        file_put_contents($name_file, $data_image);

        $data['FOTO_SISWA'] = $ID_SISWA . '.png';
        $where['ID_SISWA'] = $ID_SISWA;

        return $this->siswa->update($where, $data);
    }

    public function save_photo() {
        $ID_SISWA = $this->input->post('ID_SISWA');
        $file_element_name = 'UPLOAD_FOTO_SISWA';
        $config['upload_path'] = './files/siswa/';
        $config['allowed_types'] = 'png';
        $config['max_size'] = '2000';
        $config['max_width'] = '2400';
        $config['max_height'] = '2400';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $ID_SISWA;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_element_name)) {
            $aa = $this->upload->data();

            $data['FOTO_SISWA'] = $ID_SISWA . '.png';
            $where['ID_SISWA'] = $ID_SISWA;
            $this->siswa->update($where, $data);

            $status = TRUE;
            $msg = "berhasil diupload";
            @unlink($_FILES[$file_element_name]);
        } else {
            $status = FALSE;
            $msg = 'gagal diupload (ERROR: ' . $this->upload->display_errors('', '') . ')';
        }

        $this->generate->output_JSON(array("status" => $status, 'msg' => $msg));
    }

    public function check_data() {
        $this->generate->set_header_JSON();

        $data['name'] = $this->input->post('name');
        $data['value'] = $this->input->post('value');

        if ($this->siswa->count_all($data) == 0)
            $this->generate->output_JSON(array("status" => TRUE));
        else
            $this->generate->output_JSON(array("status" => FALSE));
    }

    public function ac_suku() {
        $this->generate->set_header_JSON();

        $data = $this->suku->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_agama() {
        $this->generate->set_header_JSON();

        $data = $this->agama->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_kondisi() {
        $this->generate->set_header_JSON();

        $data = $this->kondisi->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_jk() {
        $this->generate->set_header_JSON();

        $data = $this->jk->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_warga() {
        $this->generate->set_header_JSON();

        $data = $this->warga->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_darah() {
        $this->generate->set_header_JSON();

        $data = $this->darah->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_kecamatan() {
        $this->generate->set_header_JSON();

        $data = $this->kecamatan->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_tinggal() {
        $this->generate->set_header_JSON();

        $data = $this->tinggal->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_asal_sekolah() {
        $this->generate->set_header_JSON();

        $data = $this->asal_sekolah->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_ortu_hidup() {
        $this->generate->set_header_JSON();

        $data = $this->ortu_hidup->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_ortu_pendidikan() {
        $this->generate->set_header_JSON();

        $data = $this->pendidikan->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_ortu_pekerjaan() {
        $this->generate->set_header_JSON();

        $data = $this->pekerjaan->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_wali_hubungan() {
        $this->generate->set_header_JSON();

        $data = $this->hubungan->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_ortu_penghasilan() {
        $this->generate->set_header_JSON();

        $data = $this->penghasilan->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_jenjang_sekolah() {
        $this->generate->set_header_JSON();

        $data = $this->jenjang_sekolah->get_all_ac($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

    public function ac_siswa_kelas() {
        $this->generate->set_header_JSON();

        $data = $this->siswa->ac_siswa_kelas($this->input->post('q'));

        $this->generate->output_JSON($data);
    }

}