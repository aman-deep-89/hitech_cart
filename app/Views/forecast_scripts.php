<?php
$list=$data['list'];
$categories=$sub_categories=array();
$i=0;
$month_names=array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
foreach($list as $val) {
    $categories[$val->fc_id]=$val;
    $start_month=$val->fc_start_month;
    $months=array();
    for($k=$start_month,$j=0;$j<12;$j++) {
        $months[]=array('name'=>strtoupper(substr($month_names[$k],0,3)),'amount'=>0);
        $k++;
        $k=$k%12;
    }
    $val->months=$months;
    $sub_categories[$val->fc_id][]=$val;
    //$sub_categories[$val->fc_id][$i]['months']=$months;
}
?>
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
                distributor_name : '',
                account_number : '',
                forecast_date : '<?php echo date('d/m/Y'); ?>',
                cat_list:[],
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
                submitType:null
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
            addRow(e) {
                e.preventDefault();
                this.field_detail.push({
                name: '',
                description: '',
                enable: 1
                });                
            },
            update_date(e) {
               console.log("tar-"+event.currentTarget.value);            
            },
            checkBox(event)  {
                let id=event.target.getAttribute("id");
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