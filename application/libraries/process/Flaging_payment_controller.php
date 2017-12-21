<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Flaging_payment_controller
* @version 19-12-2017 12:48:48
*/
class Flaging_payment_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','payrollsummary_id');
        $sord = getVarClean('sord','str','desc');
        $p_finance_period_id = getVarClean('p_finance_period_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('process/flaging_payment');
            $table = $ci->flaging_payment;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();

            if ($p_finance_period_id == 0 || empty($p_finance_period_id)){
                $year = $table->comboYear()[0]['p_year_period_id'];
                $p_finance_period_id = $table->comboPeriod($year)[0]['p_finance_period_id'];
            }

            $table->setCriteria("periode = '".$p_finance_period_id."'");

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            logging('view data  flaging_payment');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','payrollsummary_id');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('process/flaging_payment');
            $table = $ci->flaging_payment;

            if(!empty($searchPhrase)) {
                //$table->setCriteria("upper(icon_code) like upper('%".$searchPhrase."%')");
            }

            $start = ($start-1) * $limit;
            $items = $table->getAll($start, $limit, $sort, $dir);
            $totalcount = $table->countAll();

            $data['rows'] = $items;
            $data['success'] = true;
            $data['total'] = $totalcount;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                permission_check('can-add-payrollsummary');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('can-edit-payrollsummary');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('can-del-payrollsummary');
                $data = $this->destroy();
            break;

            default :
                permission_check('can-view-payrollsummary');
                $data = $this->read();
            break;
        }

        return $data;
    }


    function create() {

        $ci = & get_instance();
        $ci->load->model('process/flaging_payment');
        $table = $ci->flaging_payment;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'CREATE';
        $errors = array();

        if (isset($items[0])){
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->create();

                    $table->db->trans_commit(); //Commit Trans

                }catch(Exception $e){

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';
                logging('create data flaging_payment');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update($items) {

        $ci = & get_instance();
        $ci->load->model('process/flaging_payment');
        $table = $ci->flaging_payment;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        //$jsonItems = getVarClean('items', 'str', '');
        //$items = jsonDecode($jsonItems);

        //$items = jsonDecode($items);
       // $data['message'] = $items;
         //   return $data;
        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'UPDATE';

        if (isset($items[0])){
            $errors = array();
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{
                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                }catch(Exception $e){
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                logging('update data  flaging_payment');
                $data['rows'] = $table->get($items[$table->pkey]);
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy() {
        $ci = & get_instance();
        $ci->load->model('process/flaging_payment');
        $table = $ci->flaging_payment;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');
					$table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                }
				$table->remove($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';
            logging('delete data  flaging_payment');
            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    function readDataComboYear(){

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'records' => 0, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('process/flaging_payment');
            $table = $ci->flaging_payment;

            $items = $table->comboYear();

            $html = "";
            $html.="<select name='p_year_period_id' id='p_year_period_id' class='form-control required' onchange='changePeriod()' required>";
            //$html.="<option value='' >Select Value</option>";
            foreach ($items as $item) {
              $html .=" <option value='" . $item['p_year_period_id'] . "'>" . $item['code'] . "</option>";
            }
            $html .= "</select>";

            $data['items'] = $html;
            $data['success'] = true;
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
        exit;
    }

    function readDataComboPeriod(){

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'records' => 0, 'total' => 0);
        $year = getVarClean('year', 'int', 0);
        try {

            $ci = & get_instance();
            $ci->load->model('process/flaging_payment');
            $table = $ci->flaging_payment;

            if ($year==0||empty($year))
                $year = $table->comboYear()[0]['p_year_period_id'];

            $items = $table->comboPeriod($year);

            $html = "";
            $html.="<select name='p_finance_period_id' id='p_finance_period_id' class='form-control required' required>";
            //$html.="<option value='' >Select Value</option>";
            foreach ($items as $item) {
              $html .=" <option value='" . $item['p_finance_period_id'] . "'>" . $item['finance_period_code'] . "</option>";
            }
            $html .= "</select>";

            $data['items'] = $html;
            $data['success'] = true;
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
        exit;
    }


    function readUpdate(){
        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('t_bphtb_registration_id', 'int', 0);
        $sord = getVarClean('sord', 'str', 'asc');
        $payrollsummary_id = getVarClean('payrollsummary_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            ////////////////////
            global $_FILES;

            $ci = & get_instance();
            $ci->load->model('process/flaging_payment');
            $table = $ci->flaging_payment;

            

            


            
            $req_param = array(
                "sort_by" => null,
                "sord" => null,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => null,
                "search_field" => null,
                "search_operator" =>  null,
                "search_str" =>  null
            );

            // Filter Table
            $req_param['where'] = array();

            $table->setCriteria("payrollsummary_id = '".$payrollsummary_id."'");

            $result = $table->getAll();
            $count = count($result);

            //read file excel
            if(empty($_FILES['filename']['name'])){
                throw new Exception('File tidak boleh kosong');
            }

            $typeFile = explode('/',$_FILES['filename']['type']);

            $file_name = $result[0]['emp_name'].'_'.$result[0]['periode'].'.'.$typeFile[1];//$_FILES['filename']['name']; // <-- File Name
            $file_location = './upload/evidence/'.$file_name; // <-- LOKASI Upload File
            $file_date = substr($file_name, -8);
            $file_dir = 'upload/evidence/';

            $allowed =  array('gif','png' ,'jpg','jpeg');
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if($typeFile[0] != 'image' ) {

                $data['success'] = false;
                $data['message'] = 'Format File Image, your format '.$typeFile[0];

                return $data;
            }

            if (!move_uploaded_file($_FILES['filename']['tmp_name'], $file_location)){
                $data['success'] = false;
                $data['message'] = 'Upload Gagal';

                return $data;
            }



            $table->setJQGridParam($req_param);

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - 1; // do not put $limit*($page - 1)

           
            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $result[0]['total_transfer'] = $result[0]['total_transfer'] + $result[0]['tot_remain'];
            $result[0]['payment_status'] = 'TRF';
            $result[0]['tot_remain'] = 0;
            $result[0]['path_name'] = $file_dir.''.$file_name;

            $update = $this->update($result[0]);


            $data['rows'] = $update['rows'];
            $data['success'] = $update['success'];
            $data['message'] = $update['message'];
            logging('view data  flaging_payment');
        
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }


    
}

/* End of file Flaging_payment_controller.php */