<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Kategori</h5>
                    <a href="<?= base_url('kategori/create') ?>" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $res) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $res->nama_kategori ?></td>
                                    <td>
                                        <a href="<?= base_url('kategori/edit/' . $res->kategori_id) ?>" class="btn btn-info btn-sm">
                                            <i class="align-middle bx bx-edit"></i>
                                        </a>
                                        <form action="kategori/delete/<?= $res->kategori_id ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapusnya')"><i class="align-middle bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>