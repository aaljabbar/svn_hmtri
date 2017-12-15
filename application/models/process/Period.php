<?php

/**
 * Groups Model
 *
 */
class Period extends Abstract_model {

    public $table           = "p_finance_period";
    public $pkey            = "p_finance_period_id";
    public $alias           = "per";

    public $fields          = array();

    public $selectClause    = "per.*";
    public $fromClause      = "v_p_finance_period per";

    public $refs            = array();

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db->_escape_char = ' ';
    }

    function validate() {

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['created_date'] = date('Y-m-d');
            //$this->record['updated_date'] = date('Y-m-d');
            $this->record[$this->pkey] = $this->generate_id($this->table);
        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Groups.php */