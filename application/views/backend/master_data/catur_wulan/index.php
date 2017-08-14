<?php
$title = 'Catur Wulan';
$subtitle = "Daftar semua catur wulan";
$id_datatables = 'datatable1';

$columns = array(
    'ID',
    'NAMA',
    'KETERANGAN',
    'AKTIF',
    'AKSI',
);

$this->generate->generate_panel_content("Data " . $title, $subtitle);
$this->generate->datatables($id_datatables, $title, $columns);

$id_modal = "modal-data";
$title_form = "Tambah ". $title;
$id_form = "form-data";

$this->generate->form_modal($id_modal, $title_form, $id_form, $id_datatables);

?>
<script type="text/javascript">
    var table;
    var url_delete = '<?php echo site_url('master_data/catur_wulan/ajax_delete'); ?>/';
    var url_add = '<?php echo site_url('master_data/catur_wulan/ajax_add'); ?>';
    var url_update = '<?php echo site_url('master_data/catur_wulan/ajax_update'); ?>';
    var url_form = '<?php echo site_url('master_data/catur_wulan/request_form'); ?>';
    var id_modal = '<?php echo $id_modal; ?>';
    var id_form = '<?php echo $id_form; ?>';
    var id_table = '<?php echo $id_datatables; ?>';
    var title = '<?php echo $title; ?>';
    var columns = '';//[{ "width": "100px", "targets": 2 }, {"targets": [-1],"orderable": false}];
    var orders = '';//[[ 0, "ASC" ]];
    var requestExport = true;
    var functionInitComplete = function(settings, json) {
        
    };
    var functionDrawCallback = function(settings, json) {

    };
    var functionAddData = function (e, dt, node, config) {
        create_form_input(id_form, id_modal, url_form, title, null);
    };

    $(document).ready(function () {
        table = initialize_datatables(id_table, '<?php echo site_url('master_data/catur_wulan/ajax_list'); ?>', columns, orders, functionInitComplete, functionDrawCallback, functionAddData, requestExport);
    });
    
    function action_save_<?php echo $id_datatables; ?>(id_form) {
        var status = $("#" + id_form).data("status");
        
        if(status == 'add') url = url_add;
        else if(status == 'update') url = url_update;
        
        form_save(url, id_form, table);
        
        return false;
    }
    
    function update_data_<?php echo $id_datatables; ?>(id) {
        create_form_input(id_form, id_modal, url_form, title, id);
    }
    
    function delete_data_<?php echo $id_datatables; ?>(id) {
        form_delete(url_delete, id, table);
    }

    function change_active(req_active_cawu, id) {
        if (confirm('Apakah Anda yakin mengaktifkan?')) {
            var success = function (data) {
                if(data.status) create_homer_success("Berhasil merubah status");
                else create_homer_info("Gagal merubah status");
                
                reload_datatables(table);
            };

            create_ajax('<?php echo site_url('master_data/catur_wulan/change_active'); ?>', 'AKTIF_CAWU=' + req_active_cawu + '&ID=' + id, success);
        }
    }
</script>