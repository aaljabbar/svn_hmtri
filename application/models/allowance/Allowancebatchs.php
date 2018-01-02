<?php

/*
  classname :  Allowancebatchs
  Date      : 19-12-2017 05:33:00
 
 */
class Allowancebatchs extends Abstract_model {

    public $table           = 'allowancebatchs';
    public $pkey            = 'allow_batch_id';
    public $alias           = 'allowancebatchs';

    public $fields          = array(
								'allow_batch_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allow Batch Id' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'period'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Period' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'status'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Status' ),
                                'path_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Path Name' )
                            );

    public $selectClause    =   " 
									allowancebatchs.allow_batch_id,
 									allowancebatchs.emp_master_id,
 									allowancebatchs.period,
 									allowancebatchs.created_date,
 									allowancebatchs.update_date,
 									allowancebatchs.created_by,
 									allowancebatchs.update_by,
 									allowancebatchs.status,
                                    allowancebatchs.path_name,
                                    b.emp_name,
                                    b.next_pay_dtm
                                ";
    public $fromClause      = " allowancebatchs allowancebatchs 
                                join empmaster b 
                                    on allowancebatchs.emp_master_id = b.emp_master_id
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

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception

            $this->record['update_by'] = $userdata['user_name'];
            $this->db->set('update_date',"sysdate",false);
            unset($this->record['update_date']);
        }
        return true;
    }
    function getSummaryDetail(){
        $this->table = "v_allowanceDetail";
        $this->selectClause = " allow_batch_id, DESC_ALLOWANCE,amount ";
        $this->fromClause = " (select allow_batch_id, DESC_ALLOWANCE,sum(trf_amount) amount
                                from v_allowanceDetail
                                group by allow_batch_id, desc_allowance ) ";
        
    }
    function generateDate($start, $end){

        $sql = "   SELECT  to_char(dat,'dd-MON-yyyy') dat, trim(to_char(dat,'day')) day 
                    from (
                     SELECT TO_DATE (?, 'dd-mm-yyyy') + ROWNUM - 1 dat
                                          FROM all_objects
                                         WHERE ROWNUM <=
                                                    TO_DATE (?, 'dd-mm-yyyy')
                                                  - TO_DATE (?, 'dd-mm-yyyy')
                                                  + 1 ) order by dat asc";
                 //die($sql);
        $query = $this->db->query($sql, array($start, $end, $start));
        $items = $query->result_array();

        $html = '';
        $i = 1;                
        
        $arrDay = array(
                        'sunday' => array('day' => 'Minggu', 'status' => 'weekend', 'class' => 'warning' ),
                        'monday' => array('day' =>'Senin', 'status' => 'weekday' , 'class' => '' ),
                        'tuesday' => array('day' =>'Selasa', 'status' => 'weekday' , 'class' => '' ),
                        'wednesday' => array('day' =>'Rabu', 'status' => 'weekday' , 'class' => '' ),
                        'thursday' => array('day' =>'Kamis', 'status' => 'weekday' , 'class' => '' ),
                        'friday' => array('day' =>'Jumat', 'status' => 'weekday' , 'class' => '' ),
                        'saturday' => array('day' =>'Sabtu', 'status' => 'weekend' , 'class' => 'warning' )
                    );

       

        foreach ($items as $value) {
            $day = $value['day'];
            $hari = $arrDay[$day]['day'];
            $status = $arrDay[$day]['status'];
            $class = $arrDay[$day]['class'];
            $data = $value['dat'].'|'.$hari.'|'.$status;

            $action = ' <button type="button" class="btn btn-xs green actiontable" onclick="modal_allowance_show(\'oneDate\','.$i.')" >
                        <i class="fa fa-bolt"></i>
                    </button>';

            $html .= "<tr class='".$class.' '.$status."' dataform='".$data."' id='".'dataform_'.$i."' >";
            $html .= '<td align="center"> '.$i.' </td>';
            $html .= '<td>'.$value['dat'].' </td>';
            $html .= '<td>'.$hari.' </td>';
            $html .= '<td>'.$status.' </td>';
            $html .= '<td id=\'TPD'.$i.'\'> </td>';
            $html .= '<td align="center">'.$action.' </td>';
            $html .= '</tr>';

            $i++;
        }
        return $html;
    }

    function generateDate2($start, $end){

        $sql = "   SELECT  to_char(dat,'dd-mm-yyyy') dat, trim(to_char(dat,'day')) day 
                    from (
                     SELECT TO_DATE (?, 'dd-mm-yyyy') + ROWNUM - 1 dat
                                          FROM all_objects
                                         WHERE ROWNUM <=
                                                    TO_DATE (?, 'dd-mm-yyyy')
                                                  - TO_DATE (?, 'dd-mm-yyyy')
                                                  + 1 ) order by dat asc";
                 //die($sql);
        $query = $this->db->query($sql, array($start, $end, $start));
        $items = $query->result_array();

        return $items;
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

}

/* End of file Icons.php */