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
                  <div class="card-header">Notifications</div>
                <div class="card-body">
                    <?php if(is_array($data['notifications']) && sizeof($data['notifications'])) {
                        $i=0;
                        foreach($data['notifications'] as $noti) { 
                        ?>
                            <a class="dropdown-item d-flex align-items-center" href="#" id="row<?php echo $noti->uf_id; ?>">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?php echo $noti->f_date; ?></div>
                                <span class="font-weight-bold"><?php echo $noti->f_status=='submitted' ? 'Forecast for distributor name <u>'.$noti->distributor_name.'</u> submitted' : 'Forecast for distributor name <u>'.$noti->distributor_name.'</u> is pending'; ?></span>
                            </div>
                            <div class="mr-3 ml-3 mt-3">
                                <span class="read_notification" data-id="<?php echo $noti->uf_id; ?>"><i class="fas fa-times text-info"></i></span>
                            </div>
                            </a>                    
                        <?php $i++; }  ?>                        
                    <?php } else { ?>                    
                        No new notifications
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