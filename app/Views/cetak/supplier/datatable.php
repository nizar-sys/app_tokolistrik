<div class="card-body table-responsive">
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Telpon</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataSupplier as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama_supplier ?></td>
                    <td><?= $row->no_telpon ?></td>
                    <td><?= $row->alamat ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>