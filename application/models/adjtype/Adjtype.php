<?php

/*
  classname :  Adjtype
  Date      : 18-12-2017 04:13:01
 
 */
class Adjtype extends Abstract_model {

    public $table           = 'adjtype';
    public $pkey            = 'adjtype_id';
    public $alias           = 'adjtype';

    public $fields          = array(
								'adjtype_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Adjtype Id' ),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Code' ),
 								'desc_adjtype'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Desc Adjtype' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'action'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Action' )
                            );

    public $selectClause    =   " 
									adjtype.adjtype_id,
 									adjtype.code,
 									adjtype.desc_adjtype,
 									adjtype.created_date,
 									adjtype.created_by,
 									adjtype.update_by,
 									adjtype.update_date,
 									adjtype.action
                                ";
    public $fromClause      = " adjtype adjtype ";

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

/* End of file Icons.php */