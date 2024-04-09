<div class="card-body table-responsive">
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataBarangKeluar as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['invoice'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['harga_jual'] ?></td>
                    <td><?= $row['harga_beli'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= $row['subtotal'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>