<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Cabang</h5>
            <a href="<?= base_url('data-cabang/create') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang</th>
                        <th>Alamat</th>
                        <th>Owner</th>
                        <th>Admin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $res) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $res->cabang ?></td>
                            <td><?= $res->alamat ?></td>
                            <td><?= $res->nama_owner ?></td>
                            <td><?= $res->nama_admin ?></td>
                            <td>
                                <a href="<?= base_url('data-cabang/edit/' . $res->id) ?>" class="btn btn-info btn-sm">
                                    <i class="align-middle bx bx-edit"></i>
                                </a>
                                <form action="data-cabang/delete/<?= $res->id ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapusnya')"><i class="align-middle bx bx-trash-alt"></i></button>
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