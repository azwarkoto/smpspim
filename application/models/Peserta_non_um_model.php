<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Peserta_non_um_model extends CI_Model {

    var $table = 'md_siswa';
    var $column = array('NAMA_SISWA', 'ANGKATAN_SISWA', 'JK_SISWA', 'jss.NAMA_JS', 'MASUK_TINGKAT_SISWA', 'ID_SISWA');
    var $primary_key = "ID_SISWA";
    var $order = array("ID_SISWA" => 'ASC');

    public function __construct() {
        parent::__construct();
    }

    private function _get_table() {
        $this->db->from($this->table);
        $this->db->join('md_jenjang_sekolah jss', $this->table . '.MASUK_JENJANG_SISWA=jss.ID_JS');
        $this->db->join('md_jenjang_departemen mjd', 'jss.ID_JS=mjd.JENJANG_MJD');
        $this->db->join('md_tingkat mdt', 'mdt.NAMA_TINGK='.$this->table.'.MASUK_TINGKAT_SISWA AND mdt.DEPT_TINGK=mjd.DEPT_MJD');
        $this->db->where(array(
            'STATUS_ASAL_SISWA' => 5,
            'STATUS_PSB_SISWA' => 1,
            'AKTIF_SISWA' => 0,
            'NO_UM_SISWA' => NULL,
            'STATUS_MUTASI_SISWA' => NULL,
            'ANGKATAN_SISWA' => $this->pengaturan->getTahunPSBAwal(),
        ));
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
                $this->db->like($item, $search_columns[$i]['search']['value']);
                if (count($search_columns) - 1 == $i) {
                    $this->db->group_end();
                    break;
                }
            }
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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

        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all() {
        $this->_get_table();

        return $this->db->count_all_results();
    }

    public function get_all() {
        $this->_get_table();

        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->_get_table();
        $this->db->where($this->primary_key, $id);

        return $this->db->get()->row();
    }

}
