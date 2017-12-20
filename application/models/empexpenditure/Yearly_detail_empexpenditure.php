<?php

/*
  classname :  Yearly_detail_empexpenditure
  Date      : 18-12-2017 11:49:16
 
 */
class Yearly_detail_empexpenditure extends Abstract_model {

    public $table           = 'empexpenditure';
    public $pkey            = 'empexpenditure_id';
    public $alias           = 'a';

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

    public $selectClause    =   "   a.*,
                                    b.BU_NAME
                                ";
    public $fromClause      = " empexpenditure a
                                    INNER JOIN bussinesunit b
                                ON a.bussinessunit_id = b.bussinessunit_id ";

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

/* End of file Yearly_detail_empexpenditure.php */