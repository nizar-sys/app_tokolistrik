<!-- <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Cipta Sarana</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <?php if (in_array(session()->get('role'), ['superadmin', 'admin', 'owner'])) : ?>
        <?php
        $menuItems = [
            [
                'title' => 'Cipta Sarana',
                'url' => 'home',
                'icon' => 'bx bx-home-circle',
            ],
            [
                'title' => 'Data User',
                'url' => 'data-user',
                'icon' => 'bx bx-user',
            ],
            [
                'title' => 'Master Data',
                'icon' => 'bx bx-layout',
                'subItems' => [
                    ['title' => 'Supplier', 'url' => 'supplier'],
                    ['title' => 'Kategori', 'url' => 'kategori'],
                    ['title' => 'Merk', 'url' => 'merk'],
                    ['title' => 'Rak', 'url' => 'rak'],
                    ['title' => 'Data Barang', 'url' => 'databarang'],
                ],
            ],
            [
                'title' => 'Transaksi',
                'icon' => 'bx bx-collection',
                'subItems' => [
                    ['title' => 'Barang Masuk', 'url' => 'barangmasuk'],
                    ['title' => 'Barang Keluar', 'url' => 'barangkeluar'],
                    ['title' => 'StockOpname', 'url' => 'stockopname'],
                ],
            ],
            [
                'title' => 'Laporan',
                'icon' => 'bx bx-collection',
                'subItems' => [
                    ['title' => 'Laporan Barang Masuk', 'url' => 'cetak/barangmasuk'],
                    ['title' => 'Laporan Barang Keluar', 'url' => 'cetak/barangkeluar'],
                    ['title' => 'Laporan Supplier', 'url' => 'cetak/supplier'],
                    ['title' => 'Laporan Stockopname', 'url' => 'cetak/stockopname'],
                ],
            ],
        ];
        ?>

        <ul class="menu-inner py-1">
            <?php foreach ($menuItems as $menuItem) : ?>
                <?php if (session()->get('role') == 'superadmin' || in_array($title, array_column($menuItem['subItems'] ?? [], 'title')) || $title == $menuItem['title']) : ?>
                    <li class="menu-item <?= ($menuItem['subItems'] ?? null) && in_array($title, array_column($menuItem['subItems'], 'title')) ? 'active open' : ($title == $menuItem['title'] ? 'active' : '') ?>">
                        <a href="<?= base_url() . ($menuItem['url'] ?? '') ?>" class="menu-link <?= ($menuItem['subItems'] ?? null) ? 'menu-toggle' : '' ?>">
                            <i class="menu-icon tf-icons <?= $menuItem['icon'] ?>"></i>
                            <div data-i18n="Analytics"><?= $menuItem['title'] ?></div>
                        </a>
                        <?php if ($menuItem['subItems'] ?? null) : ?>
                            <ul class="menu-sub">
                                <?php foreach ($menuItem['subItems'] as $subItem) : ?>
                                    <li class="menu-item <?= $title == $subItem['title'] ? 'active' : '' ?>">
                                        <a href="<?= base_url() . ($subItem['url'] ?? '') ?>" class="menu-link">
                                            <div data-i18n="Without menu"><?= $subItem['title'] ?></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside> -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Cipta Sarana</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <?php if (session()->get('role') == 'owner') : ?>
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?= $title == 'Cipta Sarana' ? 'active' : '' ?>">
                <a href="<?= base_url() ?>home" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Cipta Sarana</div>
                </a>
            </li>

            <li class="menu-item <?= $title == 'Data User' ? 'active' : '' ?>">
                <a href="<?= base_url() ?>data-user" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Data User</div>
                </a>
            </li>

            <li class="menu-item <?= $title == 'Data Cabang' ? 'active' : '' ?>">
                <a href="<?= base_url() ?>data-cabang" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Data Cabang</div>
                </a>
            </li>

            <li class="menu-item <?= ($title == 'Barang Masuk' || $title == 'Barang Keluar' || $title == 'StockOpname') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Layouts">Transaksi</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $title == 'StockOpname' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>stockopname" class="menu-link">
                            <div data-i18n="Container">Stockopname</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item <?= ($title == 'Laporan Barang Masuk' || $title == 'Laporan Barang Keluar' || $title == 'Laporan Supplier' || $title == 'Laporan Stockopname') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Layouts">Laporan</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $title == 'Laporan Barang Masuk' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/barangmasuk" class="menu-link">
                            <div data-i18n="Without menu">Laporan Laporan Barang Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Barang Keluar' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/barangkeluar" class="menu-link">
                            <div data-i18n="Without navbar">Laporan Barang Keluar</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Supplier' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/supplier" class="menu-link">
                            <div data-i18n="Container">Laporan Data Supplier</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Stockopname' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/stockopname" class="menu-link">
                            <div data-i18n="Container">Laporan Stockopname</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    <?php elseif (session()->get('role') == 'admin') : ?>
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?= $title == 'Cipta Sarana' ? 'active' : '' ?>">
                <a href="<?= base_url() ?>home" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Cipta Sarana</div>
                </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item <?= ($title == 'Supplier' || $title == 'Kategori' || $title == 'Merk' || $title == 'Rak' || $title == 'Data Barang') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Master Data</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $title == 'Supplier' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>supplier" class="menu-link">
                            <div data-i18n="Without menu">Supplier</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Kategori' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>kategori" class="menu-link">
                            <div data-i18n="Without navbar">Kategori</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Merk' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>merk" class="menu-link">
                            <div data-i18n="Container">Merk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Rak' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>rak" class="menu-link">
                            <div data-i18n="Fluid">Rak</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Data Barang' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>databarang" class="menu-link">
                            <div data-i18n="Blank">Data Barang</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item <?= ($title == 'Barang Masuk' || $title == 'Barang Keluar' || $title == 'StockOpname') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Layouts">Transaksi</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $title == 'Barang Masuk' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>barangmasuk" class="menu-link">
                            <div data-i18n="Without menu">Barang Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Barang Keluar' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>barangkeluar" class="menu-link">
                            <div data-i18n="Without navbar">Barang Keluar</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'StockOpname' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>stockopname" class="menu-link">
                            <div data-i18n="Container">Stockopname</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item <?= ($title == 'Laporan Barang Masuk' || $title == 'Laporan Barang Keluar' || $title == 'Laporan Supplier' || $title == 'Laporan Stockopname') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Layouts">Laporan</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $title == 'Laporan Barang Masuk' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/barangmasuk" class="menu-link">
                            <div data-i18n="Without menu">Laporan Laporan Barang Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Barang Keluar' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/barangkeluar" class="menu-link">
                            <div data-i18n="Without navbar">Laporan Barang Keluar</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Supplier' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/supplier" class="menu-link">
                            <div data-i18n="Container">Laporan Data Supplier</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $title == 'Laporan Stockopname' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>cetak/stockopname" class="menu-link">
                            <div data-i18n="Container">Laporan Stockopname</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    <?php endif; ?>
</aside>