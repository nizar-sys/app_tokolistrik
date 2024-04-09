<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Notification</h5>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th style="width: 5%;">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jumlah Barang Menipis</td>
                        <td><?= count($barangMenipis) ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" onclick="window.location.href = '<?= base_url('barang-menipis') ?>'">
                                <i class='bx bx-search-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jumlah Barang Habis</td>
                        <td><?= count($barangHabis) ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" onclick="window.location.href = '<?= base_url('barang-habis') ?>'">
                                <i class='bx bx-search-alt'></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>