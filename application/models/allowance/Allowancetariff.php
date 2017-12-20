<?php

/*
  classname :  Allowancetariff
  Date      : 19-12-2017 05:31:50
 
 */
class Allowancetariff extends Abstract_model {

    public $table           = 'allowancetariff';
    public $pkey            = 'allowancetrf_id';
    public $alias           = 'allowancetariff';

    public $fields          = array(
								'allowancetrf_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allowancetrf Id' ),
 								'trf_amount'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Trf Amount' ),
 								'valid_from'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Valid From' ),
 								'valid_until'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Valid Until' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'allowance_type_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowance Type Id' ),
 								'reference_list_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Reference List Id' )
                            );

    public $selectClause    =   " 
									allowancetariff.allowancetrf_id,
 									allowancetariff.trf_amount,
 									to_char(allowancetariff.valid_from, 'dd-mm-yyyy') valid_from,
 									to_char(allowancetariff.valid_until, 'dd-mm-yyyy') valid_until,
 									allowancetariff.created_by,
 									allowancetariff.created_date,
 									allowancetariff.update_by,
 									allowancetariff.update_date,
 									allowancetariff.allowance_type_id,
 									allowancetariff.reference_list_id,
                                    b.description
                                ";
    public $fromClause      = " allowancetariff allowancetariff
                                    join preferencelist b 
                                        ON allowancetariff.REFERENCE_LIST_ID = b.P_REFERENCE_LIST_ID
                                 ";

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
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('created_date',"sysdate",false);

            $this->db->set('valid_from',"to_date('".$this->record['valid_from']."','yyyy-mm-dd')",false);
            $this->db->set('valid_until',"to_date('".$this->record['valid_until']."','yyyy-mm-dd')",false);

            unset($this->record['valid_from']);
            unset($this->record['valid_until']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            $this->db->set('valid_from',"to_date('".$this->record['valid_from']."','yyyy-mm-dd')",false);
            $this->db->set('valid_until',"to_date('".$this->record['valid_until']."','yyyy-mm-dd')",false);
            $this->db->set('created_date',"sysdate",false);
            
            unset($this->record['valid_from']);
            unset($this->record['valid_until']);
        }
        return true;
    }

}

/* End of file Icons.php */