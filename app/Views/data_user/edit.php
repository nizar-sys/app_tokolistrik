<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data User</h5>
            <a href="<?= base_url('data-user') ?>" class="btn btn-info">Kembali</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('data-user/update/' . $res->user_id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row mb-3">
                    <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_errors('nama_lengkap') ? 'is-invalid' : '' ?>" name="nama_lengkap" id="nama_lengkap" autocomplete="off" value="<?= $res->nama_lengkap ?>">
                        <div class="form-text text-danger"><?= validation_show_error('nama_lengkap') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_errors('alamat') ? 'is-invalid' : '' ?>" name="alamat" id="alamat" autocomplete="off" value="<?= $res->alamat ?>">
                        <div class="form-text text-danger"><?= validation_show_error('alamat') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control <?= validation_errors('tanggal_lahir') ? 'is-invalid' : '' ?>" name="tanggal_lahir" id="tanggal_lahir" autocomplete="off" value="<?= $res->tanggal_lahir ?>">
                        <div class="form-text text-danger"><?= validation_show_error('tanggal_lahir') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_errors('username') ? 'is-invalid' : '' ?>" name="username" id="username" autocomplete="off" value="<?= $res->username ?>">
                        <div class="form-text text-danger"><?= validation_show_error('username') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-select <?= validation_errors('role') ? 'is-invalid' : '' ?>" name="role" id="role">
                            <option value="" selected>Pilih Role</option>
                            <?php
                            $roles = [
                                'admin' => 'Admin',
                                'owner' => 'Owner'
                            ];
                            ?>
                            <?php foreach ($roles as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= ($key == $res->role) ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-danger"><?= validation_show_error('role') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control <?= validation_errors('email') ? 'is-invalid' : '' ?>" name="email" id="email" autocomplete="off" value="<?= $res->email ?>">
                        <div class="form-text text-danger"><?= validation_show_error('email') ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="is_active" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="is_active" id="is_active" class="form-select <?= validation_errors('is_active') ? 'is-invalid' : '' ?>">
                            <option value="">--- Pilih Status ---</option>
                            <option value="1" <?= $res->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="2" <?= $res->is_active == 2 ? 'selected' : '' ?>>Dinonaktifkan</option>
                        </select>
                        <div class="form-text text-danger"><?= validation_show_error('is_active') ?></div>
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