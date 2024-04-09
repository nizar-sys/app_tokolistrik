<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tambah Data</h5>
                    <a href="<?= base_url('barangkeluar') ?>" class="btn btn-info">
                        <i class="fa-solid fa-backward"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="invoice">No. Invoice</label>
                            <input type="text" class="form-control" name="invoice" id="invoice" value="<?= $invoice ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-primary">Input Barang Masuk</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <label for="brgm_id" class="form-label">Barang</label>
                            <select class="form-select barangid" name="brgm_id" id="brgm_id" data-placeholder="Pilih Barang">
                                <option value=""></option>
                                <?php foreach ($barang as $data) : ?>
                                    <option value="<?= $data->brg_id ?>"><?= $data->nama_barang ?> | <?= $data->tanggal ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label for="aksi" class="form-label">Aksi</label>
                            <div class="d-flex">
                                <button type="button" class="btn btn-info btn-sm me-1" title="Tambah Data" id="tombolTambahItem">
                                    <i class="bx bxs-plus-square"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" title="Reload" id="tombolReload">
                                    <i class="bx bx-sync"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div id="showDataTemp" class="table-responsive"></div>
                    <input type="hidden" name="barangm_id" id="barangm_id">
                    <div class="row justify-content-end">
                        <button type="button" class="btn btn-success btn-lg" id="tombolSelesaiTransaksi">
                            <i class="fa fa-save"></i> Selesai Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function dataTemp() {
        let invoice = $('#invoice').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>barangkeluar/dataTemp",
            data: {
                invoice: invoice
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data == undefined) {
                    $('#showDataTemp').empty();
                    $('#tombolSelesaiTransaksi').hide();
                } else if (response.success) {
                    $('#showDataTemp').html(response.success);
                    $('#tombolSelesaiTransaksi').show();
                }

                console.log(response.data);
                // console.log(response.error);
                kosong()
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#barangm_id').val('');
        $('#stok').val('');
        $('#harga_jual').val('');
        $('#jumlah').val('');
    }

    function getDataObat() {
        let brgm_id = $('#brgm_id').val();

        $.ajax({
            type: "post",
            url: "<?= base_url() ?>barangkeluar/getDataBarang",
            data: {
                brgm_id: brgm_id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    let data = response.success;
                    $('#barangm_id').val(data.barang_id);
                    $('#harga_jual').val(data.harga_jual);
                    $('#stok').val(data.stok);
                    $('#jumlah').focus();
                } else {
                    console.log(response.error);
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataTemp();
        kosong();

        $('#tombolReload').click(function(e) {
            e.preventDefault();
            kosong();
            $('#brgm_id').val(null).trigger('change');
        });

        $('#brgm_id').change(function(e) {
            e.preventDefault();
            getDataObat();
        });

        $('#tombolTambahItem').click(function(e) {
            e.preventDefault();
            let invoice = $('#invoice').val();
            let brg_id = $('#brgm_id').val();
            let barang_id = $('#barangm_id').val();
            let harga_jual = $('#harga_jual').val();
            let stok = parseInt($('#stok').val());
            let jumlah = parseInt($('#jumlah').val());
            let tanggal = $('#tanggal').val();

            // console.log('stok: ' + stok, 'jumlah: ' + jumlah);

            if (invoice.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, No Invoice Wajib Diisi',
                })
            } else if (brg_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Silakan Pilih Barang Terlebih Dahulu',
                })
            } else if (jumlah.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Jumlah Tidak Boleh Kosong',
                })
            } else if (parseInt(jumlah) < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Jumlah Tidak Valid',
                })
            } else if (jumlah > stok) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Jumlah Melebihi Batas Stok',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/barangkeluar/storeBarangKeluar",
                    data: {
                        invoice: invoice,
                        brg_id: brg_id,
                        barang_id: barang_id,
                        harga_jual: harga_jual,
                        jumlah: jumlah,
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
                            dataTemp();
                            $('#brgm_id').val(null).trigger('change');
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

        $('#tombolSelesaiTransaksi').click(function(e) {
            e.preventDefault();
            let invoice = $('#invoice').val();
            let tanggal = $('#tanggal').val();

            if (invoice.length == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Message',
                    text: 'Maaf, Invoice Masih Kosong',
                })
            } else {
                Swal.fire({
                    title: 'Selesai Transaksi',
                    text: "Yakin Transaksi Ini Disimpan?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url() ?>barangkeluar/selesaiTransaksi",
                            data: {
                                invoice: invoice,
                                tanggal: tanggal
                            },
                            dataType: "JSON",
                            success: function(response) {
                                if (response.error) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Message',
                                        text: response.error,
                                    });
                                } else if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Message',
                                        text: response.success,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + '\n' + thrownError);
                            }
                        });
                    }
                })
            }
        });
    });
</script>
<?= $this->endSection() ?>