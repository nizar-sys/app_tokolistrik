<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tambah Data Barang</h5>
                    <a href="<?= base_url('databarang') ?>" class="btn btn-info">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('databarang/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?= set_value('nama_barang') ?>" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('nama_barang') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= set_value('deskripsi') ?>" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('deskripsi') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="merk_id" class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-10">
                                <select name="merk_id" id="merk_id" class="form-select">
                                    <option value="">--- Pilih Merk ---</option>
                                    <?php foreach ($merk as $merk) : ?>
                                        <option value="<?= $merk->merk_id ?>" <?= set_value('merk_id') == $merk->merk_id ? 'selected' : '' ?>><?= $merk->merk ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-danger"><?= validation_show_error('merk_id') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kategori_id" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select name="kategori_id" id="kategori_id" class="form-select">
                                    <option value="">--- Pilih Kategori ---</option>
                                    <?php foreach ($kategori as $ktg) : ?>
                                        <option value="<?= $ktg->kategori_id ?>" <?= set_value('kategori_id') == $ktg->kategori_id ? 'selected' : '' ?>><?= $ktg->nama_kategori ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-danger"><?= validation_show_error('kategori_id') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="rak_id" class="col-sm-2 col-form-label">Rak</label>
                            <div class="col-sm-10">
                                <select name="rak_id" id="rak_id" class="form-select">
                                    <option value="">--- Pilih Rak ---</option>
                                    <?php foreach ($rak as $r) : ?>
                                        <option value="<?= $r->rak_id ?>" <?= set_value('rak_id') == $r->rak_id ? 'selected' : '' ?>><?= $r->nama_rak ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-danger"><?= validation_show_error('rak_id') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?= set_value('harga_jual') ?>" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('harga_jual') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stok_alert" class="col-sm-2 col-form-label">Stok Ambang</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="stok_alert" id="stok_alert" value="<?= set_value('stok_alert') ?>" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('stok_alert') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="sampul" id="sampul" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('sampul') ?></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#harga_jual').keyup(function(e) {
            let harga_jual = $('#harga_jual').val();
            if (parseInt(harga_jual) < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Harga Jual Tidak Valid',
                })

                $('#simpan').hide();
            } else {
                $('#simpan').show();
            }
        });

        $('#stok_alert').keyup(function(e) {
            let stok_alert = $('#stok_alert').val();
            if (parseInt(stok_alert) < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Stok Ambang Tidak Valid',
                })

                $('#simpan').hide();
            } else {
                $('#simpan').show();
            }
        });
    });
</script>
<?= $this->endSection() ?>