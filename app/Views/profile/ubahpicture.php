<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Your Picture</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile/changePicture') ?>" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="avatar" class="col-sm-2 col-form-label">Picture</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="avatarOld" value="<?= $account->avatar ?>">
                                <input type="file" class="form-control" name="avatar" id="avatar" autocomplete="off">
                                <div class="form-text text-danger"><?= validation_show_error('avatar') ?></div>
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