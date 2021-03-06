<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Akad_siswa_model extends CI_Model {

    var $table = 'akad_siswa';
    var $column = array('IF(NIS_SISWA IS NULL, "-", NIS_SISWA)','IF(NO_ABSEN_AS IS NULL, "-", NO_ABSEN_AS)', 'NAMA_SISWA','ANGKATAN_SISWA','JK_SISWA','CONCAT(DEPT_TINGK, \' - \', NAMA_TINGK)','IF(NAMA_KELAS IS NULL, "-", NAMA_KELAS)','IF(NAMA_PEG IS NULL, "-", NAMA_PEG)', 'ID_AS');
    var $primary_key = "ID_AS";
    var $orders = array('NAMA_TA','NIS_SISWA','NO_ABSEN_AS', 'NAMA_SISWA','ANGKATAN_SISWA','JK_SISWA','KETERANGAN_TINGK','NAMA_KELAS','NAMA_PEG', 'ID_AS');
    var $order = array("ID_AS" => 'ASC');

    public function __construct() {
        parent::__construct();
    }

    private function _get_table() {
        $this->db->select('*, IF(NIS_SISWA IS NULL, "-", NIS_SISWA) AS NIS_SISWA_SHOW, IF(NO_ABSEN_AS IS NULL, "-", NO_ABSEN_AS) AS NO_ABSEN_AS_SHOW, IF(NAMA_KELAS IS NULL, "-", NAMA_KELAS) AS NAMA_KELAS_SHOW, IF(NAMA_PEG IS NULL, "-", NAMA_PEG) AS NAMA_PEG_SHOW');
        $this->db->from($this->table);
        $this->db->join('md_tahun_ajaran mta',$this->table.'.TA_AS=mta.ID_TA');
        $this->db->join('md_siswa ms',$this->table.'.SISWA_AS=ms.ID_SISWA');
        $this->db->join('md_tingkat mt',$this->table.'.TINGKAT_AS=mt.ID_TINGK');
        $this->db->join('akad_kelas ak',$this->table.'.KELAS_AS=ak.ID_KELAS', 'LEFT');
        $this->db->join('md_ruang mr','ak.RUANG_KELAS=mr.KODE_RUANG', 'LEFT');
        $this->db->join('md_pegawai mp','ak.WALI_KELAS=mp.ID_PEG', 'LEFT');
        $this->db->where('KONVERSI_AS', 0);
//        $this->db->where('AKTIF_AS', 1);
        $this->db->where('ID_TA', $this->session->userdata('ID_TA_ACTIVE'));
//        $this->db->join('md_tingkat mtk','ak.TINGKAT_KELAS=mtk.ID_TINGK');
//        $this->db->order_by('NAMA_TA', 'ASC');
//        $this->db->order_by('KELAS_AS', 'ASC');
//        $this->db->order_by('ID_TINGK', 'ASC');
//        $this->db->order_by('NAMA_SISWA', 'ASC');
    }

    private function _get_datatables_query() {
        $this->_get_table();
        $i = 0;
        $search_value = $_POST['search']['value'];
        $search_columns = $_POST['columns'];
        foreach ($this->column as $item) {
            if ($search_value || $search_columns) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $search_value);
                } else {
                    $this->db->or_like($item, $search_value);
                }
                if (count($search_columns) - 1 == $i) {
                    $this->db->group_end();
                    break;
                }
            }
            $column[$i] = $item;
            $i++;
        }
        $i = 0;
        foreach ($this->column as $item) {
            if ($search_columns) {
                if ($i === 0)
                    $this->db->group_start();
//                if((($search_columns[$i]['search']['value'] != "") || ($i < 7)) && ($i != 1) && ($i != 2)) 
                    $this->db->like($item, $search_columns[$i]['search']['value']);
                if (count($search_columns) - 1 == $i) {
                    $this->db->group_end();
                    break;
                }
            }
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order']) && isset($column)) {
            $this->db->order_by($this->orders[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
//        var_dump($this->db->last_query());

        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_by_id($id) {
        $this->_get_table();
        $this->db->where($this->primary_key, $id);

        return $this->db->get()->row();
    }

    public function get_by_id_simple($id) {
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);

        return $this->db->get()->row();
    }

    public function get_all($for_html = true) {
        if ($for_html) $this->db->select("ID_AS as value, NAMA_AGAMA as label");
        $this->_get_table();

        return $this->db->get()->result();
    }

    public function get_all_ac($where) {
        $this->db->select("ID_AS as id, NAMA_AGAMA as text");
        $this->_get_table();
        $this->db->like('NAMA_AGAMA', $where);

        return $this->db->get()->result();
    }

    public function count_all() {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }

    public function save($data) {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function update($where, $data) {
        $this->db->update($this->table, $data, $where);
        
        return $this->db->affected_rows();
    }

    public function delete_by_id($id) {
        $where = array($this->primary_key => $id);
        $this->db->delete($this->table, $where);
        
        return $this->db->affected_rows();
    }

    public function get_rows($where, $full = FALSE) {
        $this->_get_table();
        if($full) {
            $this->db->join('md_kecamatan kec', 'ms.KECAMATAN_SISWA=kec.ID_KEC', 'LEFT');
            $this->db->join('md_kabupaten kab', 'kec.KABUPATEN_KEC=kab.ID_KAB', 'LEFT');
            $this->db->join('md_provinsi prov', 'kab.PROVINSI_KAB=prov.ID_PROV', 'LEFT');
        }
        $this->db->where($where);
        $this->db->order_by('NAMA_SISWA', 'ASC');

        return $this->db->get()->result();
    }

    public function get_absensi($where) {
        $this->db->from($this->table);
        $this->db->join('md_siswa ms',$this->table.'.SISWA_AS=ms.ID_SISWA');
        $this->db->where('KONVERSI_AS', 0);
        $this->db->where('TA_AS', $this->session->userdata('ID_TA_ACTIVE'));
        $this->db->where($where);
        $this->db->order_by('NO_ABSEN_AS', 'ASC');

        return $this->db->get()->result();
    }

    public function get_kelas_absen_null() {
        $this->db->from($this->table);
        $this->db->where('KONVERSI_AS', 0);
        $this->db->where('KELAS_AS IS NOT NULL');
        $this->db->where('NO_ABSEN_AS IS NULL');
        $this->db->where('TA_AS', $this->session->userdata('ID_TA_ACTIVE'));
        $this->db->group_by('KELAS_AS');

        return $this->db->get()->result();
    }

    public function get_row($where) {
        $this->_get_table();
        $this->db->where($where);

        return $this->db->get()->row();
    }

    public function get_rows_array($where) {
        $this->_get_table();
        $this->db->where($where);

        return $this->db->get()->result_array();
    }

    public function get_data_sort_nilai($tingkat, $jk) {
        $this->db->from($this->table);
        $this->db->join('md_siswa ms',$this->table.'.SISWA_AS=ms.ID_SISWA');
        $this->db->where(array(
            'KONVERSI_AS' => 0,
            'AKTIF_AS' => 1,
            'AKTIF_SISWA' => 1,
            'KELAS_AS' => NULL,
            'TINGKAT_AS' => $tingkat,
            'JK_SISWA' => $jk,
            'TA_AS' => $this->session->userdata('ID_TA_ACTIVE')
        ));
        $this->db->order_by('NILAI_1_AS', 'DESC');
        $this->db->order_by('NILAI_2_AS', 'DESC');
        $this->db->order_by('NAMA_SISWA', 'DESC');

        return $this->db->get()->result_array();
    }
    
    public function konversi_tersedia($ID_SISWA, $ID_TINGKAT, $ID_KELAS) {
        $this->db->from($this->table);
        $this->db->where(array(
            'TA_AS' => $this->session->userdata("ID_TA_ACTIVE"),
            'SISWA_AS' => $ID_SISWA,
            'TINGKAT_AS' => $ID_TINGKAT,
            'KELAS_AS' => $ID_KELAS,
            'KONVERSI_AS' => 1
        ));

        if($this->db->count_all_results() > 0)
            return FALSE;
        else 
            return TRUE;
    }

    public function get_kapasitas_kelas($ID_TINGKAT) {
        $this->db->select('count(ID_AS) AS JUMLAH_SISWA');
        $this->db->from('akad_siswa as');
        $this->db->where('TA_AS', $this->session->userdata('ID_TA_ACTIVE'));
        $this->db->where('TINGKAT_AS', $ID_TINGKAT);

        $result = $this->db->get()->row();

        if($result == NULL)
            return 0;
        else 
            return $result->JUMLAH_SISWA;
    }

}
