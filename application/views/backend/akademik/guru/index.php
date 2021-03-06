<?php
$title = 'Guru';
$subtitle = "Daftar semua guru";
$id_datatables = 'datatable1';

$columns = array(
    'NIP',
    
    'NAMA',
    
    'JK',
    'ALAMAT',
    'KECAMATAN',
    'KABUPATEN',
    'NO HP',
    'EMAIL',
);

$this->generate->generate_panel_content("Data " . $title, $subtitle);
$this->generate->datatables($id_datatables, $title, $columns);
?>
<script type="text/javascript">
    var table;
    var id_table = '<?php echo $id_datatables; ?>';
    var title = '<?php echo $title; ?>';
    var columns = [{"targets": [-1],"orderable": false}];
    var orders = [[ 0, "ASC" ]];
    var requestExport = true;
    var functionInitComplete = function (settings, json) {

    };
    var functionDrawCallback = function (settings, json) {

    };
    var functionAddData = function (e, dt, node, config) {
        create_homer_error("Anda tidak memiliki hak akses untuk menambah guru.");
    };

    $(document).ready(function () {
        table = initialize_datatables(id_table, '<?php echo site_url('akademik/guru/ajax_list'); ?>', columns, orders, functionInitComplete, functionDrawCallback, functionAddData, requestExport);
    });
</script>