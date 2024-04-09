<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Your Profile</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile/changeProfile') ?>" method="post">
                        <div class="row mb-3">
                            <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" autocomplete="off" value="<?= $account->nama_lengkap ?>">
                                <div class="form-text text-danger"><?= validation_show_error('nama_lengkap') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" id="alamat" autocomplete="off" value="<?= $account->alamat ?>">
                                <div class="form-text text-danger"><?= validation_show_error('alamat') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= $account->tanggal_lahir ?>">
                                <div class="form-text text-danger"><?= validation_show_error('tanggal_lahir') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="email" autocomplete="off" value="<?= $account->email ?>">
                                <div class="form-text text-danger"><?= validation_show_error('email') ?></div>
                            </div>
                        </div>
                        <div class="row text-end">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-success" id="back">Back</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#back').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url() ?>profile';
        });
    });
</script>
<?= $this->endSection() ?>