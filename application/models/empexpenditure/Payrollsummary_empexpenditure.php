<?php

/*
  classname :  Payrollsummary_empexpenditure
  Date      : 18-12-2017 03:53:18
 
 */
class Payrollsummary_empexpenditure extends Abstract_model {

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
									a.*,b.EMP_NAME
                                ";
    public $fromClause      = " PAYROLLSUMMARY a
                                    inner join EMPMASTER b
                                    on A.EMP_MASTER_ID = B.EMP_MASTER_ID
                                    inner join BUSSINESUNIT c
                                    on B.BUSSINESSUNIT_ID = C.BUSSINESSUNIT_ID ";

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

}

/* End of file Payrollsummary_empexpenditure.php */