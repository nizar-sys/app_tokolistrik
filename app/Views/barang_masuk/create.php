<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tambah Data</h5>
                    <a href="<?= base_url('barangmasuk') ?>" class="btn btn-info">
                        <i class="fa-solid fa-backward"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="invoice">No. Invoice</label>
                            <input type="text" class="form-control" name="invoice" id="invoice" value="<?= $invoice ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="supplier">Supplier</label>
                            <select class="form-select supplier" name="supplier" id="select-field" data-placeholder="Pilih Supplier">
                                <option value=""></option>
                                <?php foreach ($supplier as $sp) : ?>
                                    <option value="<?= $sp->supplier_id ?>"><?= $sp->nama_supplier ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-primary">Input Barang Masuk</div>
                <div class="card-body">
                    <input type="date" name="dateToday" id="dateToday" value="<?= date('Y-m-d') ?>" style="display: none;">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="barang_id" class="form-label">Barang</label>
                            <select class="form-select" name="barang_id" id="barang_id" data-placeholder="Pilih Barang">
                                <option value=""></option>
                                <?php foreach ($barang as $data) : ?>
                                    <option value="<?= $data->barang_id ?>"><?= $data->nama_barang ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control" name="harga_beli" id="harga_beli" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="display: none;">
                            <label for="rak" class="form-label">Batas Rak</label>
                            <input type="text" class="form-control" name="rak" id="rak" readonly>
                        </div>
                        <div class="col-md-3" style="display: none;">
                            <label for="stokNow" class="form-label">Stok Now</label>
                            <input type="text" class="form-control" name="stokNow" id="stokNow" readonly>
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
                    <div class="table-responsive">
                        <div id="showDataTemp" class=""></div>
                    </div>
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
            url: "<?= base_url() ?>barangmasuk/dataTemp",
            data: {
                invoice: invoice
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data == undefined) {
                    $('#tombolSelesaiTransaksi').hide();
                    $('#showDataTemp').empty();
                } else if (response.data != undefined) {
                    $('#showDataTemp').html(response.success);
                    $('#tombolSelesaiTransaksi').show();
                }
                console.log(response.data);
                kosong()
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#harga_jual').val('');
        $('#harga_beli').val('');
        $('#jumlah').val('');
        $('#rak').val('');
        $('#stokNow').val('');

        $('#barang_id').focus();
    }

    function getDataBarang() {
        let barang_id = $('#barang_id').val();

        $.ajax({
            type: "post",
            url: "<?= base_url() ?>barangmasuk/getDataBarang",
            data: {
                barang_id: barang_id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    let data = response.success;
                    $('#harga_jual').val(data.harga_jual);
                    $('#rak').val(data.kapasitas);
                    $('#stokNow').val(data.stokNow ? data.stokNow : '0');

                    $('#harga_beli').focus();

                    // alert('sukses');
                }

                if (response.error) {
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

        $('#barang_id').change(function(e) {
            e.preventDefault();
            let barang_id = $('#barang_id').val();
            getDataBarang()
        });

        $('#tombolReload').click(function(e) {
            e.preventDefault();
            kosong();
            $('#barang_id').val(null).trigger('change');
        });

        $('#tombolTambahItem').click(function(e) {
            e.preventDefault();
            let invoice = $('#invoice').val();
            let barang_id = $('#barang_id').val();
            let harga_beli = $('#harga_beli').val();
            let harga_jual = $('#harga_jual').val();
            let jumlah = $('#jumlah').val();
            let supplier_id = $('#select-field').val();
            let today = $('#dateToday').val();
            let rak = $('#rak').val();
            let stokNow = $('#stokNow').val();

            if (invoice.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, No Invoice Wajib Diisi',
                })
            } else if (barang_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, ID Barang Tidak Boleh Kosong',
                })
            } else if (harga_beli.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Harga Beli Tidak Boleh Kosong',
                })
            } else if (parseInt(harga_beli) < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Harga Beli Tidak Valid',
                })
            } else if (harga_beli > harga_jual) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Harga Beli Terlalu Besar',
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
            } else if (supplier_id.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Supplier Tidak Boleh Kosong',
                })
            } else if ((parseInt(jumlah) + parseInt(stokNow)) > parseInt(rak)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Jumlah Melebihi Batas Rak',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/barangmasuk/storeTemp",
                    data: {
                        invoice: invoice,
                        barang_id: barang_id,
                        harga_beli: harga_beli,
                        harga_jual: harga_jual,
                        jumlah: jumlah,
                        supplier_id: supplier_id,
                        tanggal: today,
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
                            $('#barang_id').val(null).trigger('change');
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
            let supplier_id = $('#select-field').val();

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
                            url: "<?= base_url() ?>barangmasuk/selesaiTransaksi",
                            data: {
                                invoice: invoice,
                                tanggal: tanggal,
                                supplier_id: supplier_id,
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