<?php

/*
  classname :  Helper
  Date      : 28-11-2017 05:13:38
 
 */
class Helper_util extends Abstract_model {

    public $table           = '' ;
    public $pkey            = '' ;
    public $alias           = '' ;

    public $fields          = array(
								
                            );

    public $selectClause    =   " ";
    public $fromClause      = "  ";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function getDataParamByCode($code){
        $sql = "
            SELECT P_REFERENCE_LIST_ID ID, b.REFERENCE_NAME NAME, b.DESCRIPTION
              FROM     (select P_REFERENCE_TYPE_ID, CODE KODE
                                     from PREFERENCETYPE) a
                   JOIN
                      PREFERENCELIST b
                   ON a.P_REFERENCE_TYPE_ID = b.P_REFERENCE_TYPE_ID 
              where  a.P_REFERENCE_TYPE_ID = ? " ;
            //die($sql);
            $q = $this->db->query($sql, array($code));
            return $q->result_array();
    }

    function getDataref1($table){
     
        $sql = "
            SELECT ALLOWANCE_TYPE_ID id, DESC_ALLOWANCE name  from allowancetype " ;
     
            //die($sql);
            $q = $this->db->query($sql);
            return $q->result_array();
    }
    function getDataref2($table){
    
        $sql = "
           SELECT ALLOWANCETRF_ID id, TRF_AMOUNT name 
              from allowancetariff " ;
            //die($sql);
            $q = $this->db->query($sql);
            return $q->result_array();
    }
    function getDataref3($table){
     
        $sql = "
                  SELECT ALLOWANCE_TYPE_ID id, DESCRIPTION name  from V_TRF_ALLOWANCE 
                  order by DESCRIPTION asc
            " ;
     
            //die($sql);
            $q = $this->db->query($sql);
            return $q->result_array();
    }
}

/* End of file Icons.php */