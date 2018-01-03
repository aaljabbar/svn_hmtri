<?php

/*
  classname :  Allowancedetail
  Date      : 19-12-2017 05:33:42
 
 */
class Allowancedetail extends Abstract_model {

    public $table           = 'allowancedetail';
    public $pkey            = 'allowancedet_id';
    public $alias           = 'a';

    public $fields          = array(
								'allowancedet_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allowancedet Id' ),
 								'allow_batch_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allow Batch Id' ),
 								'allowance_type_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowance Type Id' ),
 								'allowance_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => true , 'display' =>  'Allowance Dat' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'allowancetrf_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowancetrf Id' )
                            );

    public $selectClause    =   " 
									a.allowancedet_id,
 									a.allow_batch_id,
 									a.allowance_type_id,
 									a.allowance_dat,
 									a.description,
 									a.created_date,
 									a.created_by,
 									a.update_by,
 									a.update_date,
 									a.allowancetrf_id,
                                    b.desc_allowance || ' - ' || reference_name desc_allowance,
                                    c.trf_amount
                                ";
    public $fromClause      = " allowancedetail a
                                   LEFT JOIN allowancetariff c ON a.allowancetrf_id = c.allowancetrf_id
                                  LEFT JOIN allowancetype b ON b.ALLOWANCE_TYPE_ID = c.ALLOWANCE_TYPE_ID
                                  LEFT JOIN preferencelist d on d.P_REFERENCE_LIST_ID =  c.REFERENCE_LIST_ID  
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

            $this->db->set('allowance_dat',"to_date('".$this->record['allowance_dat']."','yyyy-mm-dd')",false);
            //$this->db->set('allowancetrf_id',$this->getAllowanceTariffById($this->record['allowance_type_id']),false);
            $this->db->set('allowance_type_id',$this->getAllowanceTypeById($this->record['allowancetrf_id']),false);
            $this->db->set('created_date',"sysdate",false);

            unset($this->record['allowance_dat']);
            unset($this->record['allowance_type_id']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception
            $this->db->set('allowance_type_id',$this->getAllowanceTypeById($this->record['allowancetrf_id']),false);
            $this->db->set('update_date',"sysdate",false);

            $this->record['update_by'] = $userdata['user_name'];
            unset($this->record['allowance_type_id']);
        }
        return true;
    }

    function getAllowanceTariffById($id){
        $sql = "   SELECT ALLOWANCETRF_ID
                        from allowancetariff 
                        where ALLOWANCE_TYPE_ID = ?
                        and rownum = 1
                ";
                 //die($sql);
        $query = $this->db->query($sql, array($id));

        foreach ($query->result_array() as $row)
        {
           $ret = $row['allowancetrf_id'];
        }
        return $ret;
    }
    function getAllowanceTypeById($id){
        $sql = "   SELECT ALLOWANCE_TYPE_ID
                        from V_TRF_ALLOWANCE 
                        where ALLOWANCETRF_ID = ?
                        and rownum = 1
                ";
                 //die($sql);
        $query = $this->db->query($sql, array($id));

        foreach ($query->result_array() as $row)
        {
           $ret = $row['allowance_type_id'];
        }
        return $ret;
    }
}

/* End of file Icons.php */