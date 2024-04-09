<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Supplier</h5>
                    <a href="<?= base_url('supplier') ?>" class="btn btn-info">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('supplier/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= validation_errors('nama_lengkap') ? 'is-invalid' : '' ?>" name="nama_lengkap" id="nama_lengkap" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('nama_lengkap') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="no_telpon" class="col-sm-2 col-form-label">No Telpon</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control <?= validation_errors('no_telpon') ? 'is-invalid' : '' ?>" name="no_telpon" id="no_telpon" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('no_telpon') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= validation_errors('alamat') ? 'is-invalid' : '' ?>" name="alamat" id="alamat" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('alamat') ?></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>