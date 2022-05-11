<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
<div class="jumbtron mt-5">
<?php 
    if(session()->has("message")){ ?>
        <div class="alert alert-success"><?php echo session()->get('message'); ?></div>
    <?php } ?>    
</div>
<div class="row">          
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-12 col-md-12 mb-4">            
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-header">Activity Log</div>
                <div class="card-body">
                    <?php 
                    if(is_array($data['list']) && sizeof($data['list'])) {
                        $i=1; ?>
                        <table class="table">
                            <thead><tr><th>Sr No.</th><th>Date</th><th>IP Address</th><th>Email</th><th>Success</th></tr></thead>
                        <?php 
                        foreach($data['list'] as $noti) { ?>
                            <tr><td><?= $i ?></td><td><?= $noti->date ?></td><td><?= $noti->ip_address ?></td><td><?= $noti->email ?></td><td><?php echo $noti->success==1 ? '<span class="badge badge-success">Success</a>' : '<span class="badge badge-success">Failed</a>'; ?></td></tr>                                              
                        <?php $i++; }  ?>                        
                    </table>
                    <?php }  else { ?>                    
                        No log found
                        <?php } ?>
                    </div>
                    </div>                                        
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
  $(function() {
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>'; 
        $('.read_notification').click(function(e) {
            e.preventDefault();
            let id=$(this).data("id");
            $.ajax({                        
                url : '<?php echo site_url('forecast/read_notification'); ?>',
                data:"id="+id+"&"+csrfName+"="+csrfHash,
                type:'post',
                dataType:'json',
                async: false,
                beforeSend:function() {
                    $('#loader').show();
                },
                success:function(res) {
                    $('#loader').hide();
                    if(res.success) {
                        $('#row'+id).remove();
                    }
                    else {
                        $('#error').append(res.error);
                    }
                }
            });
        });
  });
</script>
<?= $this->endSection(); ?>