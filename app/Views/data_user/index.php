<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data User</h5>
            <a href="<?= base_url('data-user/create') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $res) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $res->nama_lengkap ?></td>
                            <td><?= $res->username ?></td>
                            <td><?= $res->alamat ?></td>
                            <td><?= $res->role ?></td>
                            <td><?= $res->is_active == 1 ? 'Aktif' : 'Dinonaktifkan' ?></td>
                            <td>
                                <a href="<?= base_url('data-user/edit/' . $res->user_id) ?>" class="btn btn-info btn-sm">
                                    <i class="align-middle bx bx-edit"></i>
                                </a>
                                <form action="data-user/delete/<?= $res->user_id ?>" method="post" class="d-inline">
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