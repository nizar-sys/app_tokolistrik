<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Cabang</h5>
            <a href="<?= base_url('data-cabang') ?>" class="btn btn-info">Kembali</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('data-cabang/update/' . $res->id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row mb-3">
                    <label for="cabang" class="col-sm-2 col-form-label">Nama Cabang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_errors('cabang') ? 'is-invalid' : '' ?>" name="cabang" id="cabang" autocomplete="off" value="<?= $res->cabang ?>">
                        <div class="form-text text-danger"><?= validation_show_error('cabang') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea class="form-control <?= validation_errors('alamat') ? 'is-invalid' : '' ?>" name="alamat" id="alamat" rows="4" autocomplete="off"><?= $res->alamat ?></textarea>
                        <div class="form-text text-danger"><?= validation_show_error('alamat') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="owner_id" class="col-sm-2 col-form-label">Owner</label>
                    <div class="col-sm-10">
                        <select class="form-select <?= validation_errors('owner_id') ? 'is-invalid' : '' ?>" name="owner_id" id="owner_id">
                            <option value="" disabled>Pilih Owner</option>
                            <?php foreach ($owners as $owner) : ?>
                                <option value="<?= $owner->user_id ?>" <?= ($owner->user_id == $res->owner_id) ? 'selected' : '' ?>>
                                    <?= $owner->nama_lengkap ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-danger"><?= validation_show_error('owner_id') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="admin_id" class="col-sm-2 col-form-label">Admin</label>
                    <div class="col-sm-10">
                        <select class="form-select <?= validation_errors('admin_id') ? 'is-invalid' : '' ?>" name="admin_id" id="admin_id">
                            <option value="" disabled>Pilih Admin</option>
                            <?php foreach ($admins as $admin) : ?>
                                <option value="<?= $admin->user_id ?>" <?= ($admin->user_id == $res->admin_id) ? 'selected' : '' ?>>
                                    <?= $admin->nama_lengkap ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-danger"><?= validation_show_error('admin_id') ?></div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>