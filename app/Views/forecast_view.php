<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
<?php
$list=$data['list'];
$categories=$sub_categories=array();
$i=0;
$month_names=array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
$distributor_name=$account_number=$user_name='';
$uf_id=0;
$forecast_date=date('d/m/Y');
$user_forecast=$month_list=array();
if(isset($data['user_list'])) {
    foreach($data['user_list'] as $ul) {
        $uf_id=$ul['uf_id'];
        $distributor_name=$ul['distributor_name'];
        $account_number=$ul['account_number'];
        $forecast_date=date('d/m/Y',strtotime($ul['forecast_date']));
        $user_forecast=json_decode($ul['forecast_data'],true);
        if(is_array($user_forecast))        
        $cat_list=array_keys($user_forecast);
        $user_name=$ul['username'].'('.$ul['email'].')';
    }
}
foreach($list as $val) {
    $categories[$val->fc_id]=$val;
    $start_month=$val->fc_start_month!=null  && $val->fc_start_month<12 ? $val->fc_start_month : date('m')-1;
    $months=array();
    for($k=$start_month,$j=0;$j<12;$j++) {
        $mon_name=strtoupper(substr($month_names[$k],0,3));
        $amt=isset($user_forecast[$val->fc_id][$val->ft_id][$mon_name]) ? $user_forecast[$val->fc_id][$val->ft_id][$mon_name] : 0;
        $months[]=array('name'=>$mon_name,'amount'=>$amt);
        $k++;
        $k=$k%12;
    }
    $val->months=$months;  
    $month_list[$val->fc_id]=$months;
    $sub_categories[$val->fc_id]['name']=$val->fc_name;  
    $sub_categories[$val->fc_id][$val->ft_id]=$val;
    //$sub_categories[$val->fc_id][$i]['months']=$months;
}
//print_r($sub_categories); exit;
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>            
</div>
<div class="row">
    <div class="col-md-12">
    <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Forecast Detail</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Print</a>
                      <a class="dropdown-item" href="<?php echo site_url('admin/download_pdf/'.$uf_id); ?>">Download PDF</a>
                      <a class="dropdown-item" href="<?php echo site_url('admin/download_csv/'.$uf_id); ?>">Download CSV</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Send AS Email</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"><strong>Distributor Name</strong><br/><?php echo $distributor_name; ?></div>
                        <div class="col-md-3"><strong>Account Number</strong><br/><?php echo $account_number; ?></div>
                        <div class="col-md-3"><strong>Forecast Date</strong><br/><?php echo $forecast_date; ?></div>
                        <div class="col-md-3"><strong>User</strong><br/><?php echo $user_name; ?></div>
                        <div class="col-12">
                            <?php foreach($sub_categories as $fc_id=>$sub_cat) { 
                                if(!in_array($fc_id,$cat_list)) continue;
                                ?>
                                <h4><?php echo $sub_cat['name']; ?></h4>
                                <?php if(is_array($sub_cat)) {  ?>
                                    <table class="table">
                                        <thead><tr><th></th>
                                            <?php foreach($month_list[$fc_id] as $mons) { ?>
                                                <th><?php echo $mons['name']; ?></th>
                                            <?php } ?>
                                        </tr></thead>
                                        <?php } 
                                    foreach($sub_cat as $key=>$val) { 
                                        if(!is_object($val)) continue;
                                        ?>
                                    <tr>
                                        <td><?php echo $val->ft_name; ?></td>
                                        <?php foreach($val->months as $mon) { ?>
                                            <td><span class="<?php echo $mon['amount']>0 ? 'text-primary' : ''; ?>"><?php echo $mon['amount']; ?></span></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </table>
                                <?php                                
                             } ?>
                        </div>
                    </div>                    
                </div>
              </div>    
</div>
</div>	
<?= $this->endSection() ?>