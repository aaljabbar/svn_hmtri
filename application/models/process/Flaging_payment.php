<?php

/*
  classname :  Flaging_payment
  Date      : 19-12-2017 12:48:49
 
 */
class Flaging_payment extends Abstract_model {

    public $table           = 'payrollsummary';
    public $pkey            = 'payrollsummary_id';
    public $alias           = '';

    public $fields          = array(
								'payrollsummary_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Payrollsummary Id' ),
 								'periode'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Periode' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'payment_status'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Payment Status' ),
 								'total_transfer'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Total Transfer' ),
 								'tot_remain'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Tot Remain' ),
 								'tot_mny'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Tot Mny' )
                            );

    public $selectClause    =   " 
									a.*,b.EMP_NAME,c.bu_name
                                ";
    public $fromClause      = " PAYROLLSUMMARY a
                                    inner join EMPMASTER b
                                    on A.EMP_MASTER_ID = B.EMP_MASTER_ID
                                    inner join BUSSINESUNIT c
                                    on B.BUSSINESSUNIT_ID = C.BUSSINESSUNIT_ID  ";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            /* $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name'];
            */
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception
        }
        return true;
    }

    function comboYear(){
        $sql = "SELECT   p_year_period_id, code
                    FROM   P_YEAR_PERIOD
                ORDER BY   p_year_period_id DESC";
        $query = $this->db->query($sql);
        $items = $query->result_array();
        return $items;
    }

    function comboPeriod($year){
        $sql = "SELECT p_finance_period_id,finance_period_code 
                    FROM p_finance_period 
                  WHERE p_year_period_id = $year
                ORDER BY p_finance_period_id DESC";
        $query = $this->db->query($sql);
        $items = $query->result_array();
        return $items;
    }

}

/* End of file Icons.php */