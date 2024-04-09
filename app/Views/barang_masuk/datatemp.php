<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Supplier</th>
            <th>User</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php if ($dataTemp == null) : ?>

        <?php else : ?>
            <?php foreach ($dataTemp as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td>Rp <?= number_format($row['harga_jual'], 0, ",", ".") ?></td>
                    <td>Rp <?= number_format($row['harga_beli'], 0, ",", ".") ?></td>
                    <td><?= number_format($row['jumlah'], 0, ",", ".") ?></td>
                    <td>Rp <?= number_format($row['subtotal'], 0, ",", ".") ?></td>
                    <td><?= $row['nama_supplier'] ?></td>
                    <td><?= $row['nama_lengkap'] ?></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusItem('<?= $row['brg_id'] ?>')">
                            <i class="bx bx-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
    function hapusItem(id) {
        Swal.fire({
            title: 'Hapus Item',
            text: "Apakah Anda Yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>barangmasuk/delete",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })

                            dataTemp();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }
</script>