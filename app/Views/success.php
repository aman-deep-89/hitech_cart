<?= $this->extend(config('SiteConfig')->homeLayout()) ?>
<?= $this->section('main') ?>
<div class="jumbtron mt-5">
<?php 
    if(session()->has("message")){ ?>
        <div class="alert alert-success"><?php echo session()->get('message'); ?></div>
    <?php } ?>
</div>
<?= $this->endSection() ?>