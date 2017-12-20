<?php

/*
  classname :  Yearly_empexpenditure
  Date      : 19-12-2017 10:10:55
 
 */
class Yearly_empexpenditure extends Abstract_model {

    public $table           = 'empexpenditure';
    public $pkey            = 'empexpenditure_id';
    public $alias           = '';

    public $fields          = array(
								'empexpenditure_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Empexpenditure Id' ),
 								'periode'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Periode' ),
 								'bussinessunit_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Bussinessunit Id' ),
 								'exp_amount'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Exp Amount' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' )
                            );

    public $selectClause    =   " 
									*
                                ";
    public $fromClause      = " v_yearly_empexpenditure ";

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

}

/* End of file Yearly_empexpenditure.php */