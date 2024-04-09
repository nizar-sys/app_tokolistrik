<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Details</h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?= base_url() ?>assets/img/avatars/<?= $account->avatar ?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                    <h5 class="card-title mb-0"><?= $account->nama_lengkap ?></h5>
                    <div class="text-muted mb-2"><?= $account->role == 'admin' ? 'Administrator' : 'Owner / Pemilik' ?></div>
                    <div>
                        <a class="btn btn-primary btn-sm" href="<?= base_url('profile/ubahProfile') ?>">Change Profile</a>
                        <a class="btn btn-primary btn-sm" href="<?= base_url('profile/ubahPicture') ?>">Change Picture</a>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">About</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <span data-feather="home" class="feather-sm me-1"></span>
                            Lives in <span class="text-info"><?= $account->alamat ?></span>
                        </li>
                        <li class="mb-1">
                            <span data-feather="calendar" class="feather-sm me-1"></span>
                            Date of birth <span class="text-info"><?= date('d F Y', strtotime($account->tanggal_lahir)) ?></span>
                        </li>
                        <li class="mb-1">
                            <span data-feather="mail" class="feather-sm me-1"></span>
                            Mail <span class="text-info"><?= $account->email ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Your Password</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile/changePassword') ?>" method="post">
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="new_password" id="new_password" class="form-control" placeholder="New Password" aria-label="New Password" autocomplete="off" value="<?= set_value('new_password') ?>">
                                <div class="form-text text-danger"><?= validation_show_error('new_password') ?></div>
                            </div>
                            <div class="col">
                                <input type="text" name="retype_new_password" id="retype_new_password" class="form-control" placeholder="Retype New Password" aria-label="Retype New Password" autocomplete="off" value="<?= set_value('retype_new_password') ?>">
                                <div class="form-text text-danger"><?= validation_show_error('retype_new_password') ?></div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>