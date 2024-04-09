<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tambah StockOpname</h5>
            <a href="<?= base_url('stockopname') ?>" class="btn btn-info">
                <i class="fa-solid fa-backward"></i> Kembali
            </a>
        </div>
        <div class="card-body row g-3">
            <div class="row g-3">
                <input type="hidden" name="so_id" id="so_id" value="<?= $res->so_id ?>">
                <div class="col-md-4">
                    <label for="kode_so" class="form-label">Kode SO</label>
                    <input type="text" class="form-control" name="kode_so" id="kode_so" value="<?= $res->kode_so ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal SO</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label for="barang_id" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" name="brg_id" id="brg_id" value="<?= $res->nama_barang ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" class="form-control" name="stock" id="stock" value="<?= $res->stok ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="stock_fisik" class="form-label">Stock Fisik</label>
                    <input type="text" class="form-control" name="stock_fisik" id="stock_fisik" autocomplete="off" value="<?= $res->stock_fisik ?>">
                </div>
                <div class="col-md-4">
                    <label for="selisih" class="form-label">Selisih Stock</label>
                    <input type="text" class="form-control" name="selisih" id="selisih" value="<?= $res->selisih ?>" readonly>
                </div>
                <div class="col-md-12">
                    <label for="selisih" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"><?= $res->keterangan ?></textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-info btn-sm" title="Tambah Data" id="tombolEditItem">
                        <i class="fa-solid fa-edit"></i> Ubah
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#stock_fisik').keyup(function(e) {
            let stock = parseInt($('#stock').val());
            let stock_fisik = parseInt($('#stock_fisik').val());
            let fisik = $('#stock_fisik').val();

            if (fisik.length == 0) {
                $('#selisih').val('');
            } else {
                let stock_now = stock - stock_fisik;

                $('#selisih').val(stock_now);
            }
        });

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();
            let so_id = $('#so_id').val();
            let fisik = $('#stock_fisik').val();
            let selisih = $('#selisih').val();
            let keterangan = $('#keterangan').val();

            if (fisik.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Stock Fisik Tidak Boleh Kosong',
                })
            } else if (keterangan.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Keterangan Tidak Boleh Kosong',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/stockopname/update",
                    data: {
                        so_id: so_id,
                        stock_fisik: fisik,
                        selisih: selisih,
                        keterangan: keterangan,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })
                            window.location.reload();
                        }

                        // console.log(response.success);
                        // console.log(response.subtotal);
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