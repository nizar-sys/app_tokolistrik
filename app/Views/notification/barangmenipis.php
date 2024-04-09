<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Barang Menipis</h5>
            <button type="" class="btn btn-primary btn-sm" onclick="window.location.href = '<?= base_url('notification') ?>'">
                <i class='bx bx-arrow-back'></i>
            </button>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Invoice</th>
                        <th>Nama Barang</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Stok</th>
                        <th>Nama Supplier</th>
                        <th style="width: 5%;">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($barangMenipis as $row) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row->invoice ?></td>
                            <td><?= $row->nama_barang ?></td>
                            <td><?= $row->harga_jual ?></td>
                            <td><?= $row->harga_beli ?></td>
                            <td><?= $row->stok ?></td>
                            <td><?= $row->nama_supplier ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusItem('<?= $row->brg_id ?>')">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
</script>
<?= $this->endSection() ?>