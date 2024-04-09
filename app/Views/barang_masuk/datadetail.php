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
        <?php foreach ($dataDetail as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td>Rp <?= number_format($row['harga_jual'], 0, ",", ".") ?></td>
                <td>Rp <?= number_format($row['harga_beli'], 0, ",", ".") ?></td>
                <td><?= number_format($row['stok'], 0, ",", ".") ?></td>
                <td>Rp <?= number_format($row['subtotal'], 0, ",", ".") ?></td>
                <td><?= $row['nama_supplier'] ?></td>
                <td><?= $row['nama_lengkap'] ?></td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusItem('<?= $row['brg_id'] ?>')">
                        <i class="bx bx-trash-alt"></i>
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="editItem('<?= $row['brg_id'] ?>')">
                        <i class="bx bx-edit-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
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
                    url: "<?= base_url() ?>barangmasuk/deleteDetail",
                    data: {
                        brg_id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            dataDetail();
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }

    function editItem(id) {
        $('#brg_id').val(id);

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>barangmasuk/editItem",
            data: {
                brg_id: $('#brg_id').val()
            },
            dataType: "JSON",
            success: function(response) {

                if (response.success) {
                    let data = response.success;

                    $('#barang_id').val(data.barang_id);
                    $('#nama_barang').val(data.nama_barang);
                    $('#harga_jual').val(data.harga_jual);
                    $('#harga_beli').val(data.harga_beli);
                    $('#jumlah').val(data.jumlah);
                    $('#jumlahOld').val(data.jumlah);
                    $('#rak').val(data.kapasitas);
                    $('#stokNow').val(data.stokNow);

                    $('#tombolEditItem').show();
                    $('#tombolReload').show();
                    $('#tombolTambahItem').hide();

                    $('#dNamaBarang').show();
                    $('#dBarangID').hide();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);

                console.log(response.data);
            }
        });
    }
</script>