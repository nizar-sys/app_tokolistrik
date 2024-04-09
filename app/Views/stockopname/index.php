<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data StockOpname</h5>
            <a href="<?= base_url('stockopname/create') ?>" class="btn btn-primary">
                <i class="fa-solid fa-plus-square"></i> Tambah Data
            </a>
        </div>
        <div class="card-body table-responsive">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode SO</th>
                        <th>Nama Barang</th>
                        <th>Stock Sistem</th>
                        <th>Stock Fisik</th>
                        <th>Selisih</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>Terakhir Diperbaharui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($result as $res) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $res->kode_so ?></td>
                            <td><?= $res->nama_barang ?></td>
                            <td><?= $res->stok ?></td>
                            <td><?= $res->stock_fisik ?></td>
                            <td><?= $res->selisih ?></td>
                            <td><?= $res->keterangan ?></td>
                            <td><?= $res->nama_lengkap ?></td>
                            <td><?= $res->updated_at ?></td>
                            <td>
                                <a href="<?= base_url() ?>stockopname/edit/<?= $res->so_id ?>" class="btn btn-success btn-sm">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <form action="<?= base_url() ?>stockopname/delete/<?= $res->so_id ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapusnya')">
                                        <i class="align-middle bx bx-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>