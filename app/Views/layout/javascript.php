<!-- <script src="<?= base_url() ?>assets/vendors/libs/jquery/jquery.js"></script> -->
<script src="<?= base_url() ?>assets/vendors/libs/popper/popper.js"></script>
<script src="<?= base_url() ?>assets/vendors/js/bootstrap.js"></script>
<script src="<?= base_url() ?>assets/vendors/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= base_url() ?>assets/vendors/js/menu.js"></script>
<script src="<?= base_url() ?>assets/vendors/libs/apex-charts/apexcharts.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>
<script src="<?= base_url() ?>assets/js/dashboards-analytics.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#example').DataTable({
                paging: true,
                ordering: true,
                info: true,
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
<script>
    $(function() {

        <?php if (session()->has("success")) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                text: '<?= session("success") ?>'
            })
        <?php } ?>
    });
</script>
<script>
    $(function() {

        <?php if (session()->has("error")) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session("error") ?>'
            })
        <?php } ?>
    });
</script>

<script>
    $('#select-field').select2({
        selectionCssClass: "select2--small",
        dropdownCssClass: "select2--small",
    });
</script>
<script>
    $('#barang_id').select2({
        selectionCssClass: "select2--small",
        dropdownCssClass: "select2--small",
    });

    $('#brgm_id').select2({
        selectionCssClass: "select2--small",
        dropdownCssClass: "select2--small",
    });
</script>