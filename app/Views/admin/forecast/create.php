<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/chosen.min.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/prism.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/style.css') ?>" />
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$fc_name=$fc_description='';
$fc_start_month=$fc_id=0;
$fc_field_detail=array();
if(isset($data['list']))
    foreach($data['list'] as $val) {
        $fc_id=$val->fc_id;
        $fc_name=$val->fc_name;
        $fc_description=$val->fc_description;
        $fc_start_month=$val->fc_start_month;
        $fc_field_detail[]=array('ft_id'=>$val->ft_id,'ft_name'=>$val->ft_name,'ft_description'=>$val->ft_description,'ft_enable'=>$val->ft_enable);
    }
?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Forecast Type</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> View List</a>
          </div>

          <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
            <?php $validation =  \Config\Services::validation(); ?>
            <?php
            // To print success flash message
            if (session()->get("success")) {
            ?>
                <div class="alert alert-success">
                    <?= session()->get("success") ?>
                </div>
            <?php
            }
            ?>

            <?php
            // To print error messages
            if (!empty($data['errors'])) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($data['errors'] as $field => $error) : ?>
                        <p><?= $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>     
            <?php
            if (session('errors')) : ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $field => $error) : ?>
                        <p><?= $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>   
            <div id="app">  
            <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul class="text-danger">
                    <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>
      
                <?php 
                echo form_open(site_url('forecast/store'),'class="user" @submit.prevent="processForm" ref="form"'); ?>
                        <div class="form-group">                        
                            <input type="text" class="form-control" v-model.trim="$v.fc_name.$model" placeholder="Name">
                            <?php if ($validation->getError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                                <div class="alert alert-danger" v-if="submitted==='PENDING' && !$v.fc_name.required">Field is required</div>
                                <div class="alert alert-danger" v-if="submitted==='PENDING' && !$v.fc_name.minLength">Name must have at least {{$v.fc_name.$params.minLength.min}} letters.</div>
                        </div>
                        <div class="form-group">
                            <label>Start From<small>(by default it will start from current month)</small></label>
                            <select v-if="months.length" v-model:trim="$v.fc_start_month.$model" class="form-control">
                                <option v-for="(value,key) in months" :value="key">{{ value[key] }}</li>                                
                            </select>
                        </div>  
                        <div class="form-group">
                        <input type="text" class="form-control" v-model="fc_description" id="fc_description" name="description" placeholder="Description">
                        <?php if ($validation->getError('description')): ?>
                            <div class="invalid-feedback">
                                    <?= $validation->getError('description') ?>
                                </div>
                            <?php endif; ?>
                        </div>  
                        <div class="form-group">
                            <a href="#" @click="addRow" class="btn btn-sm btn-primary">Add New</a>
                            <div class="alert alert-danger" v-if="submitted==='PENDING' && $v.field_detail.$error">Please add atleast {{$v.field_detail.$params.minLength.min}} categories.</div>
                            <div class="col-md-12 mt-5">
                                <div class="row text-bold">
                                    <div class="col-md-3">Name</div>
                                    <div class="col-md-3">Description (optional)</div>
                                    <div class="col-md-6">Enable</div>
                                </div>
                                <hr/>
                                <div class="row" v-for="(v, index) in $v.field_detail.$each.$iter">
                                  <div class="col-md-3">
                                          <input type="text" v-model.trim="v.name.$model" class="form-control" placeholder="Name" />
                                          <div class="form-group" :class="{ 'form-group--error': $v.field_detail.$error }"></div>
                                          <div class="text-danger" v-if="!v.name.required">Please enter name</div>
                                      </div>
                                      <div class="col-md-3">
                                            <input type="text" v-model.trim="v.description.$model" class="form-control" placeholder="Description(optional)" >
                                      </div>
                                    <div class="col-md-6">
                                    <input :id="'radio-' + index" :name="'radio-' + index" :value='1' class="radio-custom" v-model="v.enable.$model" type="radio" :checked="v.enable==1" > Yes
                                    <input :id="'radio-' + index" :name="'radio-' + index" :value='0' class="radio-custom" v-model="v.enable.$model" type="radio" :checked="v.enable==0" >  No                                   
                                        <button @click="deleteRow(index)" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <div class="btn btn-info" v-if="submitStatus === 'PENDING' || submitStatus==='SAVING'">Sending...</div>
                        <a href="<?php echo site_url('forecast/'); ?>" class="btn btn-default">Back</a>
                        <hr>
                  <?php echo form_close(); ?>
                </div> <!-- end of app -->
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
<script type="text/javascript">
var csrfName = '<?= csrf_token() ?>';
var csrfHash = '<?= csrf_hash() ?>';  
Vue.use(window.vuelidate.default)
const { required, minLength } = window.validators
    const app = new Vue({
        el: '#app',
        data() {
            return {
                fc_name:'<?= $fc_name ?>',
                fc_id:'<?= $fc_id ?>',
                fc_description:'<?= $fc_description ?>',
                months:[<?php 
                $months=array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December','Current Month');
                for($i=0;$i<13;$i++) echo '{'.$i.':"'.$months[$i].'"},'; ?>],
                fc_start_month:<?php echo $fc_start_month==null || $fc_start_month>12 ? 12 : $fc_start_month; ?> ,
                field_detail: [ <?php foreach($fc_field_detail as $val) {
                  echo "{'name':'".$val['ft_name']."','description':'".$val['ft_description']."','enable':'".$val['ft_enable']."'},";
                } ?>],
                errors: [],
                [csrfName]: csrfHash, 
                submitStatus:null,
                submitted:null
            }
        },
        validations: {
            fc_name: {
                required,
                minLength: minLength(5)
            },
            field_detail: {
                required,
                minLength: minLength(1),
                $each: {
                    name: {
                        required
                    },
                    description : {},
                    enable : { }
				}
			},
            fc_start_month : {
                required
            }		
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
            setName(value) {
                this.name = value
                //this.$v.name.$touch()
            },
            deleteRow(index) {
                this.field_detail.splice(index,1)
            },
            processForm() {
                this.submitStatus='PENDING';
                this.submitted='PENDING';
                this.$v.$touch();
                if (this.$v.$invalid) {                    
                    console.log("error"+this.field_detail.length);
                    this.submitStatus=null;
                } else {
                    var form_data=this.$data;
                    var error_log=null;
                    this.submitStatus='SAVING';
                    $.ajax({                        
                        url : '<?php echo site_url('forecast/store'); ?>',
                        data:form_data,
                        type:'post',
                        dataType:'json',
                        async: false,
                        success:function(res) {
                            if(res.success)
                                window.location=res.url;
                            else {
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
</script>
<?= $this->endSection() ?>