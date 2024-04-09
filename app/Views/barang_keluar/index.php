<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?></h4>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Invoice Barang Keluar</h5>
            <a href="<?= base_url('barangkeluar/create') ?>" class="btn btn-primary">
                <i class="fa-regular fa-square-plus"></i> Input Transaksi
            </a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total Harga</th>
                        <th style="width: 5%;">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($invoice as $inv) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $inv->invoice ?></td>
                            <td><?= $inv->tgl_invoice ?></td>
                            <td>
                                <?php
                                $db = \Config\Database::connect();
                                $jumlahItem = $db->table('tb_barangkeluar')->where('invoice', $inv->invoice)->countAllResults();
                                ?>

                                <?= $jumlahItem ?>
                            </td>
                            <td>
                                <?php
                                $db = \Config\Database::connect();
                                $query = $db->table('tb_barangkeluar')->where('invoice', $inv->invoice)->get();

                                $totalHarga = 0;
                                foreach ($query->getResultObject() as $row) {
                                    $totalHarga += $row->subtotal;
                                }
                                ?>
                                Rp <?= number_format($totalHarga, 0, ",", ".") ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info btn-sm" title="Edit Transaksi" onclick="edit('<?= $inv->invoice ?>')">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                            
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info btn-sm" title="Edit Transaksi" onclick="edit('<?= $inv->invoice ?>')">
                                    <i class=" bx bx-printer"></i>
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
    function edit(invoice) {
        window.location.href = ('<?= base_url() ?>barangkeluar/edit/') + invoice;
    }
</script>
<?= $this->endSection() ?>