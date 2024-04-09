<?php

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function hari_ini()
{
    $hari = date("D");

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return "<b>" . $hari_ini . "</b>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Supplier</title>
</head>

<body>
    <h2 style="text-align: center;">Laporan Data Supplier</h2>
    <table border="1" style="border-collapse: collapse; width: 100%;" cellspacing="2">
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
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td style="text-align: center; font-size: 15px; padding: 10px"><?= $no++ ?></td>
                    <td style="font-size: 15px; padding: 10px"><?= $row->nama_supplier ?></td>
                    <td style="font-size: 15px; padding: 10px"><?= $row->no_telpon ?></td>
                    <td style="font-size: 15px; padding: 10px"><?= $row->alamat ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="position: absolute; bottom: 100px; width: 100%; margin-right: 100px; text-align: right;">
        Jakarta, <?= hari_ini() . " " . tgl_indo(date('Y-m-d')) ?>
        <div style="margin-right: 50px;">Mengetahui,</div>
        <div style="margin-top: 100px; margin-right: 70px;">Pemilik</div>
    </div>
</body>

</html>