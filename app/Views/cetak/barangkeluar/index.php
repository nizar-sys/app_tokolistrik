<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent">
            <form action="<?= base_url() ?>cetak/printBarangKeluar" method="post">
                <div class="row g-3">
                    <div class="col">
                        <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" required>
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" required>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-success" id="lihatData">Lihat Data</button>
                        <button type="submit" class="btn btn-info d-inline" id="cetak">Cetak</button>
                        <button type="button" class="btn btn-secondary d-inline" id="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="showDataTable"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#reset').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

        $('#lihatData').click(function(e) {
            e.preventDefault();
            let tgl_awal = $('#tgl_awal').val();
            let tgl_akhir = $('#tgl_akhir').val();

            if (tgl_awal.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Mohon Pilih Tanggal Awal',
                })
            } else if (tgl_akhir.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Mohon Pilih Tanggal Akhir',
                })
            } else if (new Date(tgl_akhir) < new Date(tgl_awal)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Mohon Pilih Tanggal Yang Benar',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>cetak/dataBarangKeluar",
                    data: {
                        tgl_awal: tgl_awal,
                        tgl_akhir: tgl_akhir,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.data == undefined) {
                            $('#showDataTable').empty();
                        } else if (response.success) {
                            $('#showDataTable').html(response.success);
                        }

                        console.log(response.data);
                        // console.log(response.error);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>