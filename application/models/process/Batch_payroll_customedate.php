<?php

/**
 * Groups Model
 *
 */
class Batch_payroll_customedate extends Abstract_model {

    public $table           = "input_data_control";
    public $pkey            = "input_data_control_id";
    public $alias           = "batch";

    public $fields          = array(
                                    'input_data_control_id' => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                    'input_file_name'       => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Batch'),
                                    'invoice_date'       => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Invoice Date'),
                                    'p_bill_cycle_id'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Cycle ID'),
                                    'p_finance_period_id'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Period ID'),
                                    'input_data_class_id'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Class ID'),
                                    'file_directory'       => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'File Directory'),
                                    'creation_date'       => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                    'operator_id'       => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Operator'),
                                    'is_finish_processed'       => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Is Finish')
                                    );

    public $selectClause    = "batch.*";
    public $fromClause      = "v_input_data_control_bill batch";

    public $refs            = array();

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db->_escape_char = ' ';
    }

    function validate() {
        $ci =& get_instance();

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['created_date'] = date('Y-m-d');
            //$this->record['updated_date'] = date('Y-m-d');
            $this->record[$this->pkey] = $this->generate_id($this->table,$this->pkey);
            $this->db->set('creation_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->db->set('invoice_date',"to_date('".$this->invoice_date($this->record['p_finance_period_id'])."','dd-mon-yyyy')",false);
        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }

    function bill_cycle_combo(){
        try {
            $sql = "SELECT * FROM p_bill_cycle";
            $query = $this->db->query($sql);

            $items = $query->result_array();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['p_bill_cycle_id'].'">'.$item['code'].'</option>';
            }
            echo '</select>';
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        
    }

    function invoice_date($idd){
        $sql = "select to_char(start_date,'DD-MON-YYYY') start_date from p_finance_period where p_finance_period_id = ".$idd;
        $query = $this->db->query($sql);
        $items = '';
        if($query->num_rows() > 0){
            $result = $query->row_array();
            $items = $result['start_date'];   
        }

        return $items;
    }

    function emp_combo(){
        try {
            $sql = "SELECT 
                        * 
                    FROM empmaster
                        WHERE bussinessunit_id = 1";
            $query = $this->db->query($sql);

            $items = $query->result_array();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['emp_master_id'].'">'.$item['emp_master_id'].' - '.$item['emp_name'].' - '.$item['bussinessunit_id'].'</option>';
            }
            echo '</select>';
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        
    }

    function getEmp($emp_master_id){
        $sql = "SELECT 
                    * 
                FROM empmaster
                    WHERE emp_master_id = ".$emp_master_id;
        $query = $this->db->query($sql);

        $items = $query->row_array();
        return $items;
    }

}

/* End of file Groups.php */