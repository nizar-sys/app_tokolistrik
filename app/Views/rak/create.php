<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tambah Data Rak</h5>
                    <a href="<?= base_url('rak') ?>" class="btn btn-info">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('rak/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="cabang_id" class="col-sm-2 col-form-label">Cabang</label>
                            <div class="col-sm-10">
                                <select class="form-control <?= validation_errors('cabang_id') ? 'is-invalid' : '' ?>" name="cabang_id" id="cabang_id">
                                    <option value="">Pilih Cabang</option>
                                    <?php foreach ($cabang as $cabang_item) : ?>
                                        <option value="<?= $cabang_item->id ?>" <?= set_select('cabang_id', $cabang_item->id) ?>>
                                            <?= $cabang_item->cabang ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-danger"><?= validation_show_error('cabang_id') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nama_rak" class="col-sm-2 col-form-label">Nama Rak</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= validation_errors('nama_rak') ? 'is-invalid' : '' ?>" name="nama_rak" id="nama_rak" autocomplete="off" value="<?= set_value('nama_rak') ?>">
                                <div class="form-text text-danger"><?= validation_show_error('nama_rak') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control <?= validation_errors('kapasitas') ? 'is-invalid' : '' ?>" name="kapasitas" id="kapasitas" autocomplete="off" maxlength="3" value="<?= set_value('kapasitas') ?>">
                                <div class="form-text text-danger"><?= validation_show_error('kapasitas') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= validation_errors('lokasi') ? 'is-invalid' : '' ?>" name="lokasi" id="lokasi" autocomplete="off" value="<?= set_value('lokasi') ?>">
                                <div class="form-text text-danger"><?= validation_show_error('lokasi') ?></div>
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
        $('#kapasitas').keyup(function(e) {
            let kapasitas = $('#kapasitas').val();
            if (parseInt(kapasitas) < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Maaf, Kapasitas Tidak Valid',
                })

                $('#simpan').hide();
            } else {
                $('#simpan').show();
            }
        });
    });
</script>
<?= $this->endSection() ?>