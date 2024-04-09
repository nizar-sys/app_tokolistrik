<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url() ?>assets/" data-template="vertical-menu-template-free">

<head>
    <?= $this->include('layout/head') ?>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?= $this->include('layout/sidebar') ?>
            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include('layout/navbar') ?>
                <!-- / Navbar -->

                <div class="content-wrapper">
                    <!-- Content -->
                    <?= $this->renderSection('content') ?>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <?= $this->include('layout/javascript') ?>

</body>

</html>