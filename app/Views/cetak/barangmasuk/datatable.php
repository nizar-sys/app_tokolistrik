<div class="card-body table-responsive">
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Supplier</th>
                <th>User Input</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataBarangMasuk as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['harga_jual'] ?></td>
                    <td><?= $row['harga_beli'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= $row['subtotal'] ?></td>
                    <td><?= $row['nama_supplier'] ?></td>
                    <td><?= $row['nama_lengkap'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>