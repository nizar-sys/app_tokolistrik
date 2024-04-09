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
                    </table>
                    <input type="hidden" class="form-control" name="invoice" id="invoice" value="<?= $invoice ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-primary">Input Barang Keluar</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" id="dBarangID">
                            <label for="barang_id" class="form-label">Obat</label>
                            <select class="form-select barangid" name="brgm_id" id="brgm_id" data-placeholder="Pilih Obat">
                                <option value=""></option>
                                <?php foreach ($barang as $data) : ?>
                                    <option value="<?= $data->brg_id ?>"><?= $data->nama_barang ?> | <?= $data->tanggal ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="dNamaBarang">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <label for="aksi" class="form-label">Aksi</label>
                                <div>
                                    <button type="button" class="btn btn-info btn-sm" title="Tambah Item" id="tombolTambahItem">
                                        <i class="bx bxs-plus-square"></i>
                                    </button>

                                    <button type="button" class="btn btn-primary btn-sm" title="Edit Item" id="tombolEditItem" style="display: none;">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" title="Reload" id="tombolReload" style="display: none;">
                                        <i class="bx bx-sync"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="barangm_id" id="barangm_id">
                    <input type="hidden" name="oldJumlah" id="oldJumlah">
                    <input type="hidden" name="tanggal" id="tanggal" value="<?= $tanggal ?>">
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
            url: "<?= base_url() ?>barangkeluar/dataDetail",
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
        $('#id').val('');
        $('#barangm_id').val('');
        $('#oldJumlah').val('');
        $('#stok').val('');
        $('#harga_jual').val('');
        $('#jumlah').val('');
    }

    function getDataBarang() {
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
                    $('#nama_barang').val(data.nama_barang);
                    $('#harga_jual').val(data.harga_jual);
                    $('#jumlah').focus();

                    // alert('sukses');
                }

                if (response.error) {
                    alert(response.error);
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

        $('#dBarangID').show();
        $('#dNamaBarang').hide();

        $('#jumlah').keyup(function(e) {
            let stok = parseInt($('#stok').val());
            let jumlah = parseInt($('#jumlah').val());
            let oldJumlah = parseInt($('#oldJumlah').val());

            if (jumlah > oldJumlah) {
                let result = jumlah - oldJumlah;
                if (result > stok) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Maaf, Penambahan Stok Anda Melebihi Jumlah Stok Saat Ini',
                    })
                }
            }
        });

        $('#tombolReload').click(function(e) {
            e.preventDefault();
            $(this).hide();
            $('#tombolEditItem').hide();
            $('#tombolTambahItem').show();

            $('#dNamaBarang').hide();
            $('#dBarangID').show();

            kosong();
        });

        $('#brgm_id').change(function(e) {
            e.preventDefault();
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
                        $('#nama_barang').val(data.nama_barang);
                        $('#harga_jual').val(data.harga_jual);
                        $('#stok').val(data.stok);
                        $('#jumlah').focus();

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
                            dataDetail();
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

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();

            let harga_jual = $('#harga_jual').val();
            let stok = parseInt($('#stok').val());
            let jumlah = parseInt($('#jumlah').val());
            let oldJumlah = parseInt($('#oldJumlah').val());

            if (jumlah.length == 0) {
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
            } else if (jumlah > oldJumlah) {
                let result = jumlah - oldJumlah;
                if (result > stok) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Maaf, Penambahan Stok Anda Melebihi Jumlah Stok Saat Ini',
                    })
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>/barangkeluar/editDetailItem",
                        data: {
                            id: $('#id').val(),
                            harga_jual: harga_jual,
                            jumlah: jumlah,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.success) {
                                console.log(response.success);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Message',
                                    text: response.success,
                                })
                                kosong();
                                dataDetail();
                                $('#barang_id').val(null).trigger('change');

                                $('#dBarangID').show();
                                $('#dNamaBarang').hide();

                                $('#tombolEditItem').hide();
                                $('#tombolReload').hide();
                                $('#tombolTambahItem').show();
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
                    url: "<?= base_url() ?>/barangkeluar/editDetailItem",
                    data: {
                        id: $('#id').val(),
                        harga_jual: harga_jual,
                        jumlah: jumlah,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            console.log(response.success);
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })
                            kosong();
                            dataDetail();
                            $('#barang_id').val(null).trigger('change');

                            $('#dBarangID').show();
                            $('#dNamaBarang').hide();

                            $('#tombolEditItem').hide();
                            $('#tombolReload').hide();
                            $('#tombolTambahItem').show();
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