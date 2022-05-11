<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
<?php
$total=$pending=$submitted=$total_month=$pending_month=$submitted_month=$total_annual=$pending_annual=$submitted_annual=0;
$chart_data=array();
$current_month=date('m');
$color_code=array('rgba(78, 115, 223','rgba(232, 43, 52', 'rgba(20,200,138', 'rgba(154,41,168','rgba(178, 215, 23','rgba(87, 185, 254','rgba(8, 15, 23','rgba(22, 143, 152', 'rgba(210,20,38', 'rgba(14,141,181','rgba(181, 15, 123','rgba(187, 85, 54');
//print_r($data['statistics']); exit;
if(isset($data['statistics'])) {
  foreach($data['statistics'] as $key=>$stat) {
    if($key=='total') {
      $total=$stat->total;
      $pending=$stat->total_pending;
      $submitted=$stat->total_submitted;
    }
    else if($key=='total_monthly') {  
      foreach($stat as $stat1) {
        if($stat1->mon==$current_month) {
          $total_month=$stat1->total;
          $pending_month=$stat1->total_pending;
          $submitted_month=$stat1->total_submitted;
        }
        $total_annual+=$stat1->total;
        $pending_annual+=$stat1->total_pending;
        $submitted_annual+=$stat1->total_submitted;
        $chart_data[$stat1->mon_name]=array('total'=>$stat1->total,'pending'=>$stat1->total_pending,'submitted'=>$stat1->total_submitted);
      }
    }
  }
}
?>
          <?php 
            if(session()->has("message")){ ?>
                <div class="alert alert-success"><?php echo session()->get('message'); ?></div>
          <?php } ?>
          <!-- Content Row -->
          <div class="row">          
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Forecast (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_month; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Forecast (Annual)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Submitted (Annual)</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php 
                          $percentage=number_format($submitted_annual*100/$total_annual,0);
                          echo $percentage;
                          ?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pending ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Forecast Overview</h6>
                  <div class="dropdown no-arrow">                  
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Forecast Total</h6>
                  <div class="dropdown no-arrow">                    
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Pending
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Submitted
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<!-- Page level plugins -->
<script src="<?php echo site_url('public/vendor/chart.js/Chart.min.js'); ?>"></script>
<script type="text/javascript">
  $(function() {
    // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
          // *     example: number_format(1234.56, 2, ',', ' ');
          // *     return: '1 234,56'
          number = (number + '').replace(',', '').replace(' ', '');
          var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
            };
          // Fix for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
          }
          if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
          }
          return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [<?php $month_names=array_keys($chart_data);  foreach($month_names as $mon_name) echo '"'.$mon_name.'",'; ?>],            
            datasets: [
              <?php 
                $len=sizeof($month_names);
                for($i=0;$i<$len;$i++) { ?>
              {
              label: "<?= $month_names[$i] ?>",
              lineTension: 0.3,
              backgroundColor: "<?php echo $color_code[$i]; ?>, 0.05)",
              borderColor: "<?php echo $color_code[$i]; ?>, 1)",
              pointRadius: 3,
              pointBackgroundColor: "<?php echo $color_code[$i]; ?>, 1)",
              pointBorderColor: "<?php echo $color_code[$i]; ?>, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "<?php echo $color_code[$i]; ?>, 1)",
              pointHoverBorderColor: "<?php echo $color_code[$i]; ?>, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: [<?php 
              $type='total';
              if($i==0) $type='total';
              else if($i==1) $type='pending';
              else if($i==2) $type='submitted';
                foreach($chart_data as $mon_name=>$cd) {
                  echo $cd[$type].',';
                }
              ?>],
            },     
            <?php } ?>     
          ],
          
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return value;
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: true
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + '-' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });
        // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Pending", "Submitted"],
    datasets: [{
      data: [ <?php echo $pending.','.$submitted; ?>],
      backgroundColor: ['#4e73df', '#1cc88a'],
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

  });
</script>
<?= $this->endSection() ?>