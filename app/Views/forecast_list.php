<?= $this->section('pageStyles') ?>
<link href="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Forecast List</h6>
            </div>
            <div class="card-body">
<div class="row">
    <?php 
        if(session()->has("message")){ ?>
        <div class="alert alert-success"><?php echo session()->get('message'); ?></div>
    <?php } ?>
    <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <?php if(in_groups('Admin')) { ?>
                        <th>Created By</th>
                      <?php } ?>
                      <th>Distributor Name</th>
                      <th>Account Number</th>
                      <th>Forecast Date</th>
                      <th>Status</th>
                      <th>Creation Time</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($data['list'] as $dt) { ?>
                        <tr>
                            <td><?php echo $dt['uf_id']; ?></td>
                            <?php if(in_groups('Admin')) { ?>
                              <td><?php echo $dt['username']; ?></td>
                            <?php } ?>
                            <td><?php echo $dt['distributor_name']; ?></td>
                            <td><?php echo $dt['account_number']; ?></td>
                            <td><?php echo $dt['f_time']; ?></td>
                            <td><span class="badge <?php echo $dt['f_status']=='pending' ? 'badge-danger' : 'badge-success'; ?>"><?php echo ucfirst($dt['f_status']); ?></span></td>
                            <td><?php echo $dt['create_time']; ?></td>
                            <td>
                                <?php if($dt['f_status']=='pending' && $dt['user_id']==user_id()) { ?>
                                    <a href="<?php echo site_url('user/edit/'.$dt['uf_id']); ?>" class="text-primary"><i class="fa fa-edit"></i></a> 
                                <?php } ?>
                                <a href="<?php echo site_url('user/open/'.$dt['uf_id']); ?>" class="text-info"><i class="fa fa-folder-open"></i></a></td>
                      </tr>
                        <?php } ?>
                 </tbody>
        </table>
                      </div>
</div>
</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
  <!-- Page level plugins -->
  <script src="<?php echo site_url('public/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>
  <!-- Page level custom scripts -->
  <script src="<?php echo site_url('public/js/demo/datatables-demo.js'); ?>"></script>
<?= $this->endSection() ?>