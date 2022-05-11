<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" type="text/css" href="<?= site_url('public/vendor/foundation_datepicker/foundation-datepicker.css') ?>" />
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$list=$data['list'];
$categories=$sub_categories=array();
$i=0;
$month_names=array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December','Current Month');
$distributor_name=$account_number='';
$forecast_date=date('d/m/Y');
$user_forecast=$cat_list=array();
if(isset($data['user_list'])) {
    foreach($data['user_list'] as $ul) {
        $distributor_name=$ul['distributor_name'];
        $account_number=$ul['account_number'];
        $forecast_date=date('d/m/Y',strtotime($ul['forecast_date']));
        $user_forecast=json_decode($ul['forecast_data'],true);
        $cat_list=array_keys($user_forecast);
    }
}
foreach($list as $val) {
    $categories[$val->fc_id]=$val;
    $start_month=$val->fc_start_month!=null ? $val->fc_start_month : date('m')-1;
    $months=array();
    for($k=$start_month,$j=0;$j<12;$j++) {
        $mon_name=strtoupper(substr($month_names[$k],0,3));
        $amt=isset($user_forecast[$val->fc_id][$val->ft_id][$mon_name]) ? $user_forecast[$val->fc_id][$val->ft_id][$mon_name] : 0;
        $months[]=array('name'=>$mon_name,'amount'=>$amt);
        $k++;
        $k=$k%12;
    }
    $val->months=$months;    
    $sub_categories[$val->fc_id]['name']=$val->fc_name;
    if(in_array($val->fc_id,$cat_list) || $data['uf_id']['uf_id']==0)
        $sub_categories[$val->fc_id]['enable']=1;
    else $sub_categories[$val->fc_id]['enable']=0;
    $sub_categories[$val->fc_id][$val->ft_id]=$val;
    //$sub_categories[$val->fc_id][$i]['months']=$months;
}
//print_r($sub_categories); exit;
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>            
</div>
<div class="row" id="app">
                              <?php echo form_open('home/save',['id'=>'forecast_form','class'=>'contactForm','name'=>'contactForm','@submit.prevent'=>"processForm", 'ref'=>"form"]); ?>
										<div class="row">
                                            <?php echo form_hidden($data['uf_id']); ?>
                                            <div class="col-md-4">
												<div class="form-group">
													<label class="label" for="distributor_name">Distributor Name</label>
													<?php echo form_input($data['form_fields']['distributor_name']); ?>
                                                    <div class="alert alert-danger" v-if="submitted==='PENDING' && !$v.distributor_name.required">Field is required</div>
												</div>
											</div>
											<div class="col-md-4"> 
												<div class="form-group">
													<label class="label" for="email">Account Number</label>
													<?php echo form_input($data['form_fields']['account_number']); ?>
                                                    <div class="alert alert-danger" v-if="submitted==='PENDING' && !$v.account_number.required">Field is required</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="label" for="forecast_date">Forecast Date</label>
													<?php echo form_input($data['form_fields']['forecast_date']); ?>
                                                    <div class="alert alert-danger" v-if="submitted==='PENDING' && !$v.forecast_date.required">Field is required</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group" v-for="(obj, key, index)  in $v.categories.$each.$iter">
												    <span class="form-group" v-for="(obj2, key2, index2)  in obj.$model">
												        <input type="checkbox" :value='key2' @click="checkBox" class="category" :data-id="index2" :id="obj2.fc_id" v-model="cat_list"> {{obj2.fc_name}}
                                                    </span>
												</div>
											</div>
                                            <div class="col-md-12">
                                            <div class="alert alert-danger" v-if="submitted==='PENDING' && $v.cat_list.$error">Please add atleast {{$v.cat_list.$params.minLength.min}} categories.</div>
                                            <div class="alert alert-danger" v-if="submitted==='PENDING' && $v.categories.$error">Please add atleast {{$v.categories.$params.minLength.min}} categories.</div>
                                                <div class="form-group" v-for="(obj, key, index)  in $v.sub_categories.$each.$iter" >
                                                <table class="table" v-for="(obj2, key2, index2)  in obj.$model" :id="index2" v-if="obj2.enable===1" <?php if($data['uf_id']['uf_id']==0) echo 'style="display:none"'; ?>>
                                                    <caption>{{obj2.name}}</caption>
												    <thead>
                                                        <tr v-for="(obj3, key3, index3)  in obj2" v-if="key3==0" >
                                                            <th></th>
                                                            <th v-for="(obj4,key4,index4) in obj3.months">
                                                                {{obj4.name}}
                                                            </th>
                                                        </tr>
                                                    </thead>
												        <tr v-for="(obj5, key5, index5)  in obj2">
                                                            <th>{{obj5.ft_name}}</th>
                                                            <th v-for="(obj6,key6,index6) in obj5.months">
                                                                <input type="number"  min="0" max="999" class="form-control" v-model.trim="obj6.amount" />
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
												</div>
                                            </div>
											<div class="col-md-12">
                                                <p v-if="errors.length">
                                                    <b>Please correct the following error(s):</b>
                                                    <ul class="text-danger">
                                                    <li v-for="error in errors">{{ error }}</li>
                                                    </ul>
                                                </p>
                                            </div>
											<div class="col-md-12">
												<div class="form-group">
													<input type="submit" value="Save Progress" @click="submitType='saveProgress'" class="btn btn-primary">
													<input type="submit" value="Submit"  @click="submitType='submit'"  class="btn btn-primary">
													<span id="loader" class="btn btn-info" style="display:none"><i class="fa fa-spin fa-spinner"></i> Saving </span>
												</div>
											</div>
										</div>
									</form>
								</div>	
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="loginForm" method="post" action="<?= site_url('public').route_to('login') ?>">
      <?= csrf_field() ?>
        <div class="modal-body">
            <div id="error2" class="text-danger"></div>
            <div class="form-group">
                <label for="uemail">Email address</label>
                <input type="text" class="form-control" name="login" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="hidden" name="type" value="ajax" />
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>           
            </div>
            <div class="modal-footer">                
                <a class="self-align-center" href="<?php echo site_url().route_to('register') ?>">Register</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Login</button>
                <span id="loader2" class="btn btn-info" style="display:none"><i class="fa fa-spin fa-spinner"></i> Logging In </span>
            </div>
            </form>
    </div>
  </div>
</div>            
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/chosen.jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/prism.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/init.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/vuejs/vue.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/vuejs/vue-autoextra.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/vuejs/vuelidate.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/vuejs/validators.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/foundation_datepicker/foundation-datepicker.js') ?>"></script>
<script type="text/javascript">
var csrfName = '<?= csrf_token() ?>';
var csrfHash = '<?= csrf_hash() ?>';  
Vue.use(window.vuelidate.default)
const { required, minLength } = window.validators
    const app = new Vue({
        el: '#app',
        data() {
            return {
                distributor_name : '<?php echo $distributor_name; ?>',
                uf_id : '<?php echo $data['uf_id']['uf_id']; ?>',
                account_number : '<?php echo $account_number; ?>',
                forecast_date : '<?php echo $forecast_date; ?>',
                cat_list:[<?php echo implode(',',$cat_list); ?>],
                submitType:null
                categories:[<?php 
                    echo json_encode($categories);
                    ?>],
                sub_categories:[<?php 
                    echo json_encode($sub_categories);
                    ?>],
                errors: [],
                [csrfName]: csrfHash, 
                submitStatus:null,
                submitted:null,
            }
        },
        validations: {
            distributor_name: {
                required,
               // minLength: minLength(5)
            },
            account_number: {
                required,
               // minLength: minLength(5)
            },
            forecast_date: {
            },
            categories: {
                $each : {
                   fc_name : { },
                   fc_id : { }
                }
            },
            cat_list: {
                required,
                minLength: minLength(1),                
            },
            sub_categories : {
                //minLength:minLength(1),
                name: {},
                enable: {},
                $each: {
                    fc_id : {
                        $each : {
                            months:[],
                            ft_name:{},
                            amount:{}
                        }
                    }
				}
			},	
        },
        mounted: function() {
            var self = this;
            $('#forecast_date').fdatepicker({ format:'dd/mm/yyyy',startDate:'1940-01-01'}).on('changeDate', function (evt) {
                var ev = new Date(evt.date);
                self.forecast_date= ev.getDate()+'/'+("0"+(ev.getMonth()+1)).slice(-2)+'/'+ev.getFullYear();
                /*
                newDate.setDate(newDate.getDate());
                self.forecast_date=newDate;*/
            });
        },
        methods: {
            update_date(e) {
               console.log("tar-"+event.currentTarget.value);            
            },
            checkBox(event)  {
                let id=parseInt(event.target.getAttribute("id"));
                if(event.target.checked) {
                    this.cat_list.push(id);
                    console.log("="+id);
                } else {
                    let ind=this.cat_list.indexOf(id);
                    this.cat_list.splice(ind,1);
                }            
                console.log(this.cat_list);
            },
            processForm() {
                this.submitStatus='PENDING';
                this.submitted='PENDING';
                this.$v.$touch();
                if (this.$v.$invalid) {
                    console.log(this.$v.forecast_date);
                    console.log(this.submitType);
                    this.submitStatus=null;
                } else {
                    var form_data=this.$data;
                    var error_log=null;
                    this.submitStatus='SAVING';
                    $.ajax({                        
                        url : '<?php echo site_url('home/save_user_forecast'); ?>',
                        data:form_data,
                        type:'post',
                        dataType:'json',
                        async: false,
                        beforeSend:function() {
                            $('#loader').show();
                        },
                        success:function(res) {
                            $('#loader').show();
                            if(res.success)
                                window.location=res.url;
                            else if(res.login) {
                                $('#loginModal').modal('show');
                            } else {
                                error_log=res.errors;
                            }
                        }
                    });
                    this.submitStatus=null;
                    if(error_log) {
                        let error_list=[];
                        $.each(error_log, function(key,value) {                            
                            error_list.push(value);
                        });
                        this.errors.push(error_list);    
                        console.log(this.errors);
                    }
                    //this.$refs.form.submit()
               }
            }
        }
    });
    $(function() {
        $('.category').click(function(e) {
            var chked=$(this).prop("checked");
            var id=$(this).data("id");
            if(chked) $('#'+id).show();
            else $('#'+id).hide();
        });
        $('#forecast_date').change(function(){
            $(this).attr('value', $('#forecast_date').val());
            console.log("value="+$(this).val());
        });
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            let act_url=$(this).attr("action");
            let form_data=$(this).serialize();
            $.ajax({                        
                url : act_url,
                data:form_data,
                type:'post',
                dataType:'json',
                async: false,
                beforeSend:function() {
                    $('#loader2').show();
                },
                success:function(res) {
                    $('#loader2').hide();
                    if(res.success) {
                        $('#loginModal').modal('hide');
                        $('#login_btn').hide();
                        $('#d_username').text(res.username);
                        $('#d_email').text(res.email);
                        $('#user_detail').show();
                    }
                    else {
                        $('#error2').html("");
                        $.each(res.error,function(index,val) {
                            $('#error2').append(val+'<br/>');
                        });
                        $('#error2').append(res.error2);
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>