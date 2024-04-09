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
        <div class="card-body">
            <div class="row g-3">
                <input type="hidden" name="barangm_id" id="barangm_id">
                <div class="col-md-4">
                    <label for="kode_so" class="form-label">Kode SO</label>
                    <input type="text" class="form-control" name="kode_so" id="kode_so" value="<?= $kodeSO ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal SO</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label for="brg_id" class="form-label">Nama Barang</label>
                    <select class="form-select" name="brg_id" id="select-field" data-placeholder="Pilih Barang">
                        <option value=""></option>
                        <?php foreach ($dataBarang as $data) : ?>
                            <option value="<?= $data->brg_id ?>"><?= $data->nama_barang ?> - <?= $data->invoice ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" class="form-control" name="stock" id="stock" readonly>
                </div>
                <div class="col-md-4">
                    <label for="stock_fisik" class="form-label">Stock Fisik</label>
                    <input type="text" class="form-control" name="stock_fisik" id="stock_fisik" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="selisih" class="form-label">Selisih Stock</label>
                    <input type="text" class="form-control" name="selisih" id="selisih" readonly>
                </div>
                <div class="col-md-12">
                    <label for="selisih" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="col-12 text-end mt-2">
                    <button type="button" class="btn btn-info " title="Tambah Data" id="tombolTambahItem">
                        <i class="fa-solid fa-square-plus"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#barangm_id').val('');
        $('#stock').val('');
        $('#stock_fisik').val('');
        $('#selisih').val('');
        $('#keterangan').val('');
    }

    $(document).ready(function() {
        $('#select-field').change(function(e) {
            e.preventDefault();
            let brg_id = $('#select-field').val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>stockopname/getStockBarang",
                data: {
                    brg_id: brg_id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        let data = response.success;
                        $('#barangm_id').val(data.barang_id);
                        $('#stock').val(data.stok);
                        $('#stock_fisik').focus();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#stock_fisik').keyup(function(e) {
            let brg_id = $('#select-field').val();
            let stock = parseInt($('#stock').val());
            let stock_fisik = parseInt($('#stock_fisik').val());
            let fisik = $('#stock_fisik').val();

            if (brg_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Silakan Lakukan Pemilihan Barang Terlebih Dahulu',
                })

                $('#selisih').val('');
            } else if (fisik.length == 0) {
                $('#selisih').val('');
            } else {
                let stock_now = stock - stock_fisik;

                $('#selisih').val(stock_now);
            }
        });

        $('#tombolTambahItem').click(function(e) {
            e.preventDefault();
            let kode_so = $('#kode_so').val();
            let brg_id = $('#select-field').val();
            let barang_id = $('#barangm_id').val();
            let fisik = $('#stock_fisik').val();
            let selisih = $('#selisih').val();
            let keterangan = $('#keterangan').val();
            let tanggal = $('#tanggal').val();

            if (brg_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Pilih Barang Terlebih Dahulu',
                })
            } else if (fisik.length == 0) {
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
                    url: "<?= base_url() ?>/stockopname/store",
                    data: {
                        kode_so: kode_so,
                        brg_id: brg_id,
                        barang_id: barang_id,
                        stock_fisik: fisik,
                        selisih: selisih,
                        keterangan: keterangan,
                        tanggal: tanggal,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })
                            kosong();
                            $('#select-field').val(null).trigger('change');
                            window.location.reload();
                        }
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