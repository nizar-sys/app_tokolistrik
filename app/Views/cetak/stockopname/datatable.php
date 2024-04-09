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
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataStockopname as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['kode_so'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td><?= $row['stock_fisik'] ?></td>
                    <td><?= $row['selisih'] ?></td>
                    <td><?= $row['nama_lengkap'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>