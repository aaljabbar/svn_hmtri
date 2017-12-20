<?php defined('BASEPATH') OR exit('No direct script access allowed');
require('fpdf/fpdf.php');
require('fpdf/invClassExtend.php');

class Pdf_payroll_summary extends CI_Controller{
    var $fontSize = 10;
    var $fontFam = 'Arial';
    var $yearId = 0;
    var $yearCode="";
    var $paperWSize = 210 ;
    var $paperHSize = 297;
    var $height = 5;
    var $currX;
    var $currY;
    var $widths;
    var $aligns;

    function __construct() {
        parent::__construct();
        $pdf = new FPDF();
        $this->startY = $pdf->GetY();
        $this->startX = $this->paperWSize-42;
        $this->lengthCell = $this->startX+20;
    }

    function newLine(){
        $pdf = new FPDF();
        $pdf->Cell($this->lengthCell, $this->height, "", "", 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
    }

    function save_pdf() {

        //print_r($this->mainData());exit;
        
        $mainData = $this->mainData();

        $pdf = new FPDF('L', 'mm', array(210  ,210));
        
        $pdf->AliasNbPages();
        $pdf->AddPage("L");
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, $this->height, $mainData['bu_name'], "", 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, $this->height, $this->dateToday(), "", 0, 'R');

        $pdf->ln();
        $pdf->Cell(0, $this->height, $mainData['address'], "", 0, 'L');
        $pdf->Cell(-50, $this->height, "Name :", "", 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, $this->height, $mainData['emp_name'], "", 0, 'R');
        $pdf->SetFont('Arial', '', 10);

        $pdf->ln();
        $pdf->Cell(0, $this->height, "Telp.".$mainData['no_telp'], "", 0, 'L');
        $pdf->Cell(-50, $this->height, "Periode :", "", 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, $this->height, $mainData['periode'], "", 0, 'R');
        $pdf->SetFont('Arial', '', 10);

        $pdf->ln();
        $pdf->Cell(0, $this->height, "", "", 0, 'L');
        $pdf->Cell(-50, $this->height, "Take Home Pay :", "", 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, $this->height, number_format($mainData['tot_mny'], 2, '.', ',')." (IDR)", "", 0, 'R');

        $pdf->ln();

        //$pdf->Image(base_url().'assets/image/triklin.jpg',20,20,50,20);

        $ltable = $this->lengthCell / 3;
        $ltable1 = $ltable * 0.3;
        $ltable2 = $ltable * 1.5;
        $ltable3 = $ltable * 1.2;
        //$ltable4 = $ltable * 1;
        $pdf->SetDrawColor(0,80,180);
        $pdf->SetFillColor(230,230,0);
        //$pdf->SetTextColor(220,50,50);


        $pdf->Cell($ltable1, $this->height + 2, "NO", "TBLR", 0, 'C');
        $pdf->Cell($ltable2, $this->height + 2, "Description", "TBR", 0, 'C');
        $pdf->Cell($ltable3, $this->height + 2, "Total Amount", "TBR", 0, 'C');


        $datas = $this->detailData();
        $no = 1;
        $temp = '';
        $justTemp = '';
        $pdf->ln();
        $pdf->SetFont('Arial', '', 10);
        foreach ($datas as $data) {
          
          if ($temp != $data['pyr_code_type']){
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($ltable1, $this->height + 2, $no++, "BLR", 0, 'C');
            $pyrcodetype = $this->pyrcodetype($data['pyr_code_type']);
            $sumTot = $this->sumTot($data['pyr_code_type'],null);
            $pdf->Cell($ltable2, $this->height + 2,$pyrcodetype, "BR", 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($ltable3, $this->height + 2, number_format($sumTot, 2, '.', ','), "BR", 0, 'R');

            $temp = $data['pyr_code_type'];

             $pdf->ln();
          }

         
        }

        $pdf->ln();
        $pdf->ln();

        $pdf->SetDrawColor(220,50,5);
        //$pdf->SetFillColor(220,50,5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($ltable1, $this->height + 2, "NO", "TBLR", 0, 'C');
        $pdf->Cell($ltable2, $this->height + 2, "Description", "TBR", 0, 'C');
        $pdf->Cell($ltable3, $this->height + 2, "Total Amount", "TBR", 0, 'C');


        $datas = $this->detailData();
        $no = 1;
        $temp = '';
        $justTemp = '';
        $pdf->ln();
        $pdf->SetFont('Arial', '', 10);
        foreach ($datas as $data) {
          
          if ($temp != $data['pyr_code_type']){
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell($ltable1, $this->height + 2, $no++, "BLR", 0, 'C');
            $pyrcodetype = $this->pyrcodetype($data['pyr_code_type']);

            if ($data['pyr_code_type'] == 4 ){
              $pdf->Cell($ltable2, $this->height + 2,$pyrcodetype, "BR", 0, 'L');
              $pdf->SetFont('Arial', '', 10);
              $pdf->Cell($ltable3, $this->height + 2, number_format($data['payroll_mny'], 2, '.', ','), "BR", 0, 'R');
            }else{
              $pdf->Cell($ltable2+$ltable3, $this->height + 2,$pyrcodetype, "BR", 0, 'L');
            }

            $temp = $data['pyr_code_type'];

             $pdf->ln();
          }

          if ($data['pyr_code_type'] != 4 ){
            
            $pdf->SetFont('Arial', '', 10);

            $tes = $data['pyr_ext_id'].'-'.$data['pyr_code_type'];

            if ($justTemp != $tes){
              $sumTot = $this->sumTot($data['pyr_code_type'],$data['pyr_ext_id']);
              $pyrcodetypeExt = $this->pyrcodetypeExt($data['pyr_code_type'],$data['pyr_ext_id']);
              $pdf->Cell($ltable1, $this->height + 2, "", "BLR", 0, 'C');
              $pdf->Cell($ltable2, $this->height + 2, $pyrcodetypeExt, "BR", 0, 'L');
              $pdf->Cell($ltable3, $this->height + 2, number_format($sumTot, 2, '.', ','), "BR", 0, 'R');

              $pdf->ln();
              
            }
            $justTemp = $data['pyr_ext_id'].'-'.$data['pyr_code_type'];
            
          }
        }

        $this->newLine();

        $pdf->Cell(0, $this->height+5, "Penerima", "", 0, 'L');
        $pdf->Cell(-5, $this->height + 5, "Bandung, ".$this->dateToday(), "", 0, 'R');

        $pdf->ln();
        $pdf->ln();

        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(0, $this->height, $mainData['emp_name'], "", 0, 'L');
        $pdf->Cell(-20, $this->height , "Lia Yuliani", "", 0, 'R');
        $pdf->ln();

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, $this->height, "", "", 0, 'L');
        $pdf->Cell(-20, $this->height, "GA Officer", "", 0, 'R');
        
        $pdf->Output();
    } 

    function mainData(){
        $p_finance_period_id = getVarClean('p_finance_period_id', 'int', 0);
        $payrollsummary_id = getVarClean('payrollsummary_id', 'int', 0);

        $sql = "SELECT   a.*,B.BUSSINESSUNIT_ID,b.EMP_NAME,c.bu_name,c.ADDRESS,c.NO_TELP
                FROM         PAYROLLSUMMARY a
                          INNER JOIN
                             EMPMASTER b
                          ON A.EMP_MASTER_ID = B.EMP_MASTER_ID
                       INNER JOIN
                          BUSSINESUNIT c
                       ON B.BUSSINESSUNIT_ID = C.BUSSINESSUNIT_ID
                WHERE a.PAYROLLSUMMARY_ID = ".$payrollsummary_id;
        $query = $this->db->query($sql);
        $items = $query->row_array();
        return $items;
    }

    function detailData(){
        $payrollsummary_id = getVarClean('payrollsummary_id', 'int', 0);

        $sql = "SELECT   a.*, B.PYR_EXT_ID, B.PYR_CODE_TYPE
                  FROM      PAYROLLDETAIL a
                         INNER JOIN
                            PYRCODE b
                         ON A.PYR_CODE_ID = B.PYR_CODE_ID
                WHERE a.PAYROLLSUMMARY_ID = ".$payrollsummary_id."
                ORDER by B.PYR_CODE_TYPE  DESC";
        $query = $this->db->query($sql);
        $items = $query->result_array();

        return $items;
    }


    function pyrcodetype($pyr_code_type){
      $sql = "SELECT PYR_CODE_TYPE,PYRTYPE_CODE,PYRTYPE_DESC FROM PYRCODETYPE WHERE PYR_CODE_TYPE = ".$pyr_code_type;
      $query = $this->db->query($sql);
      $items = $query->row_array();

      return $items['pyrtype_desc'];
    }

    function pyrcodetypeExt($pyr_code_type,$pyr_ext_id){

        if($pyr_code_type == 1){
          $sql = "SELECT ALLOWANCE_TYPE_ID,CODE,DESC_ALLOWANCE AS DESCRIPTiON FROM ALLOWANCETYPE WHERE ALLOWANCE_TYPE_ID = ".$pyr_ext_id;
        }else if($pyr_code_type == 2){
          $sql = "SELECT DEDUCTIONTYPE_ID,CODE,DESCRIPTION AS DESCRIPTiON FROM DEDUCTIONTYPE WHERE DEDUCTIONTYPE_ID = ".$pyr_ext_id;
        }else if($pyr_code_type == 3){
          $sql = "SELECT ADJTYPE_ID,CODE,DESC_ADJTYPE AS DESCRIPTiON FROM ADJTYPE WHERE ADJTYPE_ID = ".$pyr_ext_id;
        }else if($pyr_code_type == 4){
          $sql = "SELECT PYR_CODE_TYPE,PYRTYPE_CODE,PYRTYPE_DESC  AS DESCRIPTiON FROM PYRCODETYPE WHERE PYR_CODE_TYPE = ".$pyr_code_type;
        }

        $query = $this->db->query($sql);
        $items = $query->row_array();
              

        return $items['description'];
    }

    function sumTot($pyr_code_type,$pyr_ext_id){
      $payrollsummary_id = getVarClean('payrollsummary_id', 'int', 0);

      $sql = "SELECT   SUM (PAYROLL_MNY) as SUM
                FROM      PAYROLLDETAIL a
                       INNER JOIN
                          PYRCODE b
                       ON A.PYR_CODE_ID = B.PYR_CODE_ID
               WHERE   a.PAYROLLSUMMARY_ID =".$payrollsummary_id." 
               AND PYR_CODE_TYPE =  ".$pyr_code_type;

      if(!empty($pyr_ext_id)){
        $sql .= " AND PYR_EXT_ID = ".$pyr_ext_id;
      }

      $query = $this->db->query($sql);
      $items = $query->row_array();

      return $items['sum'];
    }




    
    
    function dateToString($tanggal){
      if(empty($tanggal)) return "";
  
      $monthname = array(0  => '-',
                         1  => 'Januari',
                         2  => 'Februari',
                         3  => 'Maret',
                         4  => 'April',
                         5  => 'Mei',
                         6  => 'Juni',
                         7  => 'Juli',
                         8  => 'Agustus',
                         9  => 'September',
                         10 => 'Oktober',
                         11 => 'November',
                         12 => 'Desember');    
      
      $pieces = explode('-', $tanggal);
      
      return $pieces[2].' '.$monthname[(int)$pieces[1]].' '.$pieces[0];
    }

    function dateToday(){
      $tanggal = date("d m Y");
      if(empty($tanggal)) return "";
      
      $monthname = array(0  => '-',
                         1  => 'Januari',
                         2  => 'Februari',
                         3  => 'Maret',
                         4  => 'April',
                         5  => 'Mei',
                         6  => 'Juni',
                         7  => 'Juli',
                         8  => 'Agustus',
                         9  => 'September',
                         10 => 'Oktober',
                         11 => 'November',
                         12 => 'Desember');    
      
      $pieces = explode(' ', $tanggal);
      
      return $pieces[0].' '.$monthname[(int)$pieces[1]].' '.$pieces[2];
    }

}


