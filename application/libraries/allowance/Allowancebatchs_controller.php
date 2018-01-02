<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Allowancebatchs_controller
* @version 19-12-2017 05:33:00
*/
class Allowancebatchs_controller {

    function generateDate(){
        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

        $start = getVarClean('start_date','str','');
        $end = getVarClean('end_date','str','');

        $data = array('success'=>false, 'data'=>'', 'message'=>'');

         try{
               $item = $table->generateDate($start, $end);
               $data['data'] = $item;
            }catch (Exception $e) {
                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }
        echo json_encode($data);
        exit();
    }
    function submitDataForm(){
        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

        $emp_master_id = getVarClean('emp_master_id','str','');
        $dataform = getVarClean('dataform','str','');

        $data = array('success'=>false, 'data'=>'', 'message'=>'');
        try{
               $dataSummary = array(
                                'allow_batch_id' => '',
                                'emp_master_id' => $emp_master_id,
                                'period' => date('Ym')
               );
               $summary = $this->createForm($dataSummary);

               $item = json_decode($dataform, true);
               $dataRec = array();
               $i = 0;
               foreach ($item as $key => $value) {
                    //$value = $value[$i];
                    $dataRec[$i] = array(
                                    'allowancedet_id' => '',
                                    'allow_batch_id' => $summary['id'],
                                    'allowance_type_id' => $value['allowance_type_id'],
                                    'description' => $value['description'],
                                    'allowance_dat' => $value['allowance_dat'],
                                    'allowancetrf_id'=> $table->getAllowanceTariffById($value['allowance_type_id'])
                    );

                    $i++;
               }
               
               $this->createFormAllowanceDetail($dataRec);

               $data['success'] = true;
               $data['message'] = 'successfully added data';
            }catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        echo json_encode( $data);
        //echo var_dump($item);
        exit();
    }
    function submitData(){
        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

        $emp_master_id = getVarClean('emp_master_id','str','');
        $start = getVarClean('start_date','str','');
        $end = getVarClean('end_date','str','');
        $allowance_type = getVarClean('allowance_type','int','0');

        $data = array('success'=>false, 'data'=>'', 'message'=>'');

         try{
               $dataSummary = array(
                                'allow_batch_id' => '',
                                'emp_master_id' => $emp_master_id,
                                'period' => $start
               );
               $summary = $this->createForm($dataSummary);

               $item = $table->generateDate2($start, $end);
               $dataform = array();
               $i = 0;
               foreach ($item as $key => $value) {
                    
                    $dataform[$i] = array(
                                    'allowancedet_id' => '',
                                    'allow_batch_id' => $summary['id'],
                                    'allowance_type_id' => $allowance_type,
                                    'allowance_dat' => $value['dat'],
                                    'allowancetrf_id'=> $table->getAllowanceTariffById($allowance_type)
                    );

                    $i++;
               }
               
               $this->createFormAllowanceDetail($dataform);

               $data['success'] = true;
               $data['message'] = 'successfully added data';
            }catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        echo json_encode($data);
        exit();
    }
    function createFormAllowanceDetail($dataJson) {

        $ci = & get_instance();
        $ci->load->model('allowance/allowancedetail');
        $table = $ci->allowancedetail;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = json_encode($dataJson);
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
                logging('create data allowancedetail');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }
    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','allow_batch_id');
        $sord = getVarClean('sord','str','desc');
        $celValue = getVarClean('celValue','str','0');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('allowance/allowancebatchs');
            $table = $ci->allowancebatchs;

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
            $req_param['where'] = array('allowancebatchs.emp_master_id = '.$celValue);

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
            logging('view data  allowancebatchs');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function readSub() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','allow_batch_id');
        $sord = getVarClean('sord','str','desc');
        $celValue = getVarClean('celValue','str','0');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('allowance/allowancebatchs');
            $table = $ci->allowancebatchs;
            $table->getSummaryDetail();
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
            $req_param['where'] = array('allow_batch_id = '.$celValue);

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
            logging('view data  allowancebatchs');
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function readLov() {

        $start = getVarClean('current','int',0);
        $limit = getVarClean('rowCount','int',5);

        $sort = getVarClean('sort','str','allow_batch_id');
        $dir  = getVarClean('dir','str','asc');

        $searchPhrase = getVarClean('searchPhrase', 'str', '');

        $data = array('rows' => array(), 'success' => false, 'message' => '', 'current' => $start, 'rowCount' => $limit, 'total' => 0);

        try {

            $ci = & get_instance();
            $ci->load->model('allowance/allowancebatchs');
            $table = $ci->allowancebatchs;

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
                permission_check('can-add-allowancebatchs');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('can-edit-allowancebatchs');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('can-del-allowancebatchs');
                $data = $this->destroy();
            break;

            default :
                permission_check('can-view-allowancebatchs');
                $data = $this->read();
            break;
        }

        return $data;
    }

    function createForm($datajson) {

        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '', 'id'=>0);

        $jsonItems = json_encode($datajson);
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

                $data['id'] = $table->record[$table->pkey];
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
                logging('create data allowancebatchs');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }
    function create() {

        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

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
                logging('create data allowancebatchs');

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('allowance/allowancebatchs');
        $table = $ci->allowancebatchs;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

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
                logging('update data  allowancebatchs');
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
        $ci->load->model('allowance/allowancebatchs');
        $ci->load->model('allowance/allowancedetail');
        $tableallowancedetail = $ci->allowancedetail;
        $table = $ci->allowancebatchs;

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
                
                
                $tableallowancedetail->db->delete($tableallowancedetail->table, array('allow_batch_id' => $items));
				$table->remove($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';
            logging('delete data  allowancebatchs');
            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    function readUpdate(){



        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('t_bphtb_registration_id', 'int', 0);
        $sord = getVarClean('sord', 'str', 'asc');
        $allow_batch_id = getVarClean('allow_batch_id','int',0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            ////////////////////
            global $_FILES;

            $ci = & get_instance();
            $ci->load->model('allowance/allowancebatchs');
            $table = $ci->allowancebatchs;
            
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

            $table->setCriteria("allow_batch_id = ".$allow_batch_id);

            $result = $table->getAll();
            $count = count($result);

            //read file excel
            if(empty($_FILES['filename']['name'])){
                throw new Exception('File tidak boleh kosong');
            }

            $file_name = $result[0]['emp_name'].'_'.$result[0]['period'].'_'.$_FILES['filename']['name']; // <-- File Name
            $file_location = './upload/allowance/'.$file_name; // <-- LOKASI Upload File
            $file_date = substr($file_name, -8);
            $file_dir = 'upload/allowance/';

            $allowed =  array('gif','png' ,'jpg','jpeg');
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if(!in_array($ext,$allowed) ) {

                $data['success'] = false;
                $data['message'] = 'Format File gif,png,jpg,jpeg. ';

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

            /*$result[0]['total_transfer'] = $result[0]['total_transfer'] + $result[0]['tot_remain'];
            $result[0]['payment_status'] = 'TRF';
            $result[0]['tot_remain'] = 0;*/

            $result[0]['status'] = 'TRF';
            $result[0]['path_name'] = $file_dir.''.$file_name;

           // $update = $this->update($result[0]);

            if (!is_array($result[0])){
                $data['message'] = 'Invalid items parameter';
                return $data;
            }

            // $data['message'] = $result[0];
            // return $data;

            $table->actionType = 'UPDATE';

            $table->db->trans_begin(); //Begin Trans

            $table->setRecord($result[0]);
            $table->update();

            $table->db->trans_commit();


            //$data['rows'] = $update['rows'];
            $data['success'] = true;
            $data['message'] = 'Data update successfully';
            logging('update data  allowancebatchs');
            $data['rows'] = $table->getAll();
        
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }
}

/* End of file Icons_controller.php */