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
                    <table class="table table-sm table-striped table-hover" style="width: 100%;">
                        <tr>
                            <td style="width: 20%;">No. Invoice</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%;"><?= $invoice ?></td>
                            <td rowspan="3" class="align-middle text-center fw-bold fs-2" id="totalHarga"></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Tanggal </td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%;"><?= $tanggal ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Supplier </td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%;"><?= $supplier_name ?></td>
                        </tr>
                    </table>
                    <input type="hidden" class="form-control" name="invoice" id="invoice" value="<?= $invoice ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-primary">Input Barang Masuk</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3" id="dBarangID">
                            <label for="barang_id" class="form-label">Barang</label>
                            <select class="form-select" name="barang_id" id="barang_id" data-placeholder="Pilih Barang">
                                <option value=""></option>
                                <?php foreach ($barang as $data) : ?>
                                    <option value="<?= $data->barang_id ?>"><?= $data->nama_barang ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3" id="dNamaBarang" style="display: none;">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
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
                            <div>
                                <button type="button" class="btn btn-info btn-sm" title="Tambah Item" id="tombolTambahItem">
                                    <i class="bx bxs-plus-square"></i>
                                </button>

                                <button type="button" class="btn btn-primary btn-sm" title="Edit Item" id="tombolEditItem" style="display: none;">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" title="Reload" id="tombolReload" style="display: none;">
                                    <i class="bx bx-sync"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="brg_id" id="brg_id">
                    <input type="hidden" name="jumlahOld" id="jumlahOld">
                    <input type="hidden" name="tanggal" id="tanggal" value="<?= $tanggal ?>">
                    <input type="hidden" name="supplier_id" id="supplier_id" value="<?= $supplier_id ?>">
                    <div id="showDataDetail" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function dataDetail() {
        let invoice = $('#invoice').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>barangmasuk/dataDetail",
            data: {
                invoice: invoice
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data == undefined) {
                    $('#showDataDetail').empty();
                    $('#totalHarga').empty();
                } else if (response.success) {
                    $('#showDataDetail').html(response.success);
                    $('#totalHarga').html(response.totalHarga);
                } else if (response.error) {
                    console.log(response.error);
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#barang_id').val('');
        $('#nama_barang').val('');
        $('#harga_jual').val('');
        $('#harga_beli').val('');
        $('#jumlah').val('');
        $('#jumlahOld').val('');
        $('#brg_id').val('');
        $('#rak').val('');
        $('#stokNow').val('');


        $('#barang_id').focus();

        $('#dBarangID').show();
        $('#dNamaBarang').hide();
    }

    function getDataObat() {
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
                    $('#nama_barang').val(data.nama_barang);
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
        dataDetail();

        $('#supplier_id').css('pointer-events', 'none');

        $('#barang_id').change(function(e) {
            e.preventDefault();
            let barang_id = $('#barang_id').val();
            getDataObat();
        });

        $('#tombolReload').click(function(e) {
            e.preventDefault();
            $(this).hide();
            $('#dBarangID').show();
            $('#dNamaBarang').hide();

            $('#tombolEditItem').hide();
            $('#tombolTambahItem').show();

            kosong();
        });

        $('#tombolTambahItem').click(function(e) {
            e.preventDefault();
            let invoice = $('#invoice').val();
            let barang_id = $('#barang_id').val();
            let harga_beli = $('#harga_beli').val();
            let harga_jual = $('#harga_jual').val();
            let jumlah = $('#jumlah').val();
            let jumlahOld = $('#jumlahOld').val();
            let supplier_id = $('#supplier_id').val();
            let tanggal = $('#tanggal').val();
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
                    text: 'Maaf, Barang Tidak Boleh Kosong',
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
                    text: 'Maaf, Jumlah Melebihi Batas Rak Obat',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/barangmasuk/storeBarangMasuk",
                    data: {
                        invoice: invoice,
                        barang_id: barang_id,
                        harga_beli: harga_beli,
                        harga_jual: harga_jual,
                        jumlah: jumlah,
                        supplier_id: supplier_id,
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
                            dataDetail();

                            $('#barang_id').val(null).trigger('change');
                        }

                        console.log(response.success);
                        console.log(response.subtotal);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();
            let invoice = $('#invoice').val();
            let harga_beli = $('#harga_beli').val();
            let harga_jual = $('#harga_jual').val();
            let jumlah = $('#jumlah').val();
            let jumlahOld = $('#jumlahOld').val();
            let supplier_id = $('#supplier_id').val();
            let rak = $('#rak').val();
            let stokNow = $('#stokNow').val();

            if (invoice.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, No Invoice Wajib Diisi',
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
            } else if (parseInt(jumlah) > parseInt(jumlahOld)) {
                let hasil = parseInt(jumlah) - parseInt(jumlahOld);
                if ((parseInt(hasil) + parseInt(stokNow)) > parseInt(rak)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Maaf, Penambahan Jumlah Melebihi Batas Rak Obat',
                    })
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>/barangmasuk/editDetailItem",
                        data: {
                            brg_id: $('#brg_id').val(),
                            invoice: invoice,
                            harga_beli: harga_beli,
                            harga_jual: harga_jual,
                            jumlah: jumlah,
                            supplier_id: supplier_id,
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
                                dataDetail();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>/barangmasuk/editDetailItem",
                    data: {
                        brg_id: $('#brg_id').val(),
                        invoice: invoice,
                        harga_beli: harga_beli,
                        harga_jual: harga_jual,
                        jumlah: jumlah,
                        supplier_id: supplier_id,
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
                            dataDetail();
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