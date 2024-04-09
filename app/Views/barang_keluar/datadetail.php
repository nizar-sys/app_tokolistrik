<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
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
                <td><?= number_format($row['jumlah'], 0, ",", ".") ?></td>
                <td>Rp <?= number_format($row['subtotal'], 0, ",", ".") ?></td>
                <td><?= $row['nama_lengkap'] ?></td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusItem('<?= $row['id'] ?>')">
                        <i class="bx bx-trash-alt"></i>
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="editItem('<?= $row['id'] ?>')">
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
                    url: "<?= base_url() ?>barangkeluar/deleteDetail",
                    data: {
                        brg_id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message',
                                text: response.success,
                            })

                            dataDetail();
                            window.location.reload();
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
        $('#id').val(id);

        $('#dObatID').hide();
        $('#dNamaObat').show();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>barangkeluar/editItem",
            data: {
                id: $('#id').val()
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    let data = response.success;

                    $('#barangm_id').val(data.barang_id);
                    $('#nama_barang').val(data.nama_barang);
                    $('#harga_jual').val(data.harga_jual);
                    $('#stok').val(data.stok);
                    $('#jumlah').val(data.jumlah);
                    $('#oldJumlah').val(data.jumlah);

                    $('#tombolEditItem').show();
                    $('#tombolReload').show();
                    $('#tombolTambahItem').hide();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);

                console.log(response.data);
            }
        });
    }
</script>