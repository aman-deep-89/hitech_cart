<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserForecastModel extends Model
{
    protected $table = 'user_forecast';
    protected $primaryKey = 'uf_id';

    protected $returnType = 'object';
    protected $allowedFields = [
        'distributor_name', 'account_number','forecast_date','user_id','session_id','forecast_data','f_status','admin_notification_read','user_notification_read'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
       
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    public function saveForecastType($info,$fc_id) {
        $this->db->table('forecast_type')->where('fc_id',$fc_id)->delete();
        $res=$this->db->table('forecast_type')->insertBatch($info);
        //echo $this->db->getLastQuery();
        return true;
    }
}
