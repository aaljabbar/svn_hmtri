<?php

/*
  classname :  Empmaster
  Date      : 28-11-2017 05:13:38
 
 */
class Empmaster extends Abstract_model {

    public $table           = 'empmaster';
    public $pkey            = 'emp_master_id';
    public $alias           = 'emp';

    public $fields          = array(
								'emp_master_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'bussinessunit_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Bussinessunit Id' ),
 								'emp_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Name' ),
 								'nick_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Nick Name' ),
 								'address'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Address' ),
 								'nik'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Nik' ),
 								'path_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Path Name' ),
 								'npwp_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Npwp Code' ),
 								'no_ktp'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Ktp' ),
 								'tgl_lhr'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Tgl Lhr' ),
 								'tmpt_lhr'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Tmpt Lhr' ),
 								'start_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Start Dat' ),
 								'end_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'End Dat' ),
 								'status'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Status' ),
 								'emp_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Code' ),
 								'bpjs_tk_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bpjs Tk Code' ),
 								'bpjs_kes_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bpjs Kes Code' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
                                'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'jenis_kelamin'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' )
                            );

    public $selectClause    =   " 
									emp.emp_master_id,
 									emp.bussinessunit_id,
 									emp.emp_name,
 									emp.nick_name,
 									emp.address,
 									emp.nik,
 									emp.path_name,
 									emp.npwp_code,
 									emp.no_ktp,
 									emp.tgl_lhr,
 									emp.tmpt_lhr,
 									emp.start_dat,
 									emp.end_dat,
 									emp.status,
 									emp.emp_code,
 									emp.bpjs_tk_code,
 									emp.bpjs_kes_code,
 									emp.created_by,
 									emp.created_date,
 									emp.update_date,
 									emp.update_by,
                                    emp.jenis_kelamin
                                ";
    public $fromClause      = " empmaster emp ";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
			
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('created_date',"sysdate",false);

			$this->db->set('start_dat',"to_date('".$this->record['start_dat']."','yyyy-mm-dd')",false);
			$this->db->set('tgl_lhr',"to_date('".$this->record['tgl_lhr']."','yyyy-mm-dd')",false);

            unset($this->record['created_date']);
			unset($this->record['start_dat']);
			unset($this->record['tgl_lhr']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
           
            $this->db->set('update_date',"sysdate",false);
			$this->db->set('start_dat',"to_date('".$this->record['start_dat']."','yyyy-mm-dd')",false);
            $this->db->set('tgl_lhr',"to_date('".$this->record['tgl_lhr']."','yyyy-mm-dd')",false);

            $this->record['update_by'] = $userdata['user_name'];

            unset($this->record['update_date']);
            unset($this->record['start_dat']);
            unset($this->record['tgl_lhr']);
            
        }
        return true;
    }
    function getparam($codea){
        $sql = "SELECT P_REFERENCE_LIST_ID ID, b.REFERENCE_NAME NAME, b.DESCRIPTION
                  FROM    smshubberdev.PREFERENCETYPE a
                       JOIN
                          smshubberdev.PREFERENCELIST b
                       ON a.P_REFERENCE_TYPE_ID = b.P_REFERENCE_TYPE_ID
                 WHERE upper(a.code) = upper(trim('EMPSTATUS')) ";
                 //die($sql);
        $query = $this->db->query($sql);
        $items = $query->result_array();
        return $items;
    }
}

/* End of file Icons.php */