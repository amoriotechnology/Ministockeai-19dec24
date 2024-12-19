<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Hrm_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }



public function state_tax_list()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->distinct();
    $this->db->where('tax_type', 'state_tax');
    $this->db->where('created_by', $user_id);
    $query = $this->db->get('tax_history');
     if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
    return 0;
    }
}


public function state_tax_list_living()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->distinct();
    $this->db->where('tax_type', 'living_state_tax');
    $this->db->where('created_by', $user_id);
    $query = $this->db->get('tax_history');  
    // echo $this->db->last_query(); die();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
    return 0;
    }
}







public function state_summary_employee($emp_name = 'All', $taxChoice = null, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('DISTINCT a.timesheet_id, a.cheque_date, d.code,c.id as id, c.first_name, c.middle_name, c.last_name, d.tax_type, d.tax, SUM(d.amount) as total_amount', false);
    $this->db->from('timesheet_info a');
    $this->db->join('info_payslip b', 'b.templ_name = a.templ_name');
    $this->db->join('employee_history c', 'c.id = b.templ_name');
    $this->db->join('tax_history_employer d', 'd.time_sheet_id = a.timesheet_id', 'left');
    $this->db->where("TRIM(d.tax_type) != 'local_tax'");
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->where("(TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')");
    }
    if ($date) {
        $dates = explode(' to ', $date);
        if (count($dates) == 2) {
            $start_date = $dates[0];
            $end_date = $dates[1];
            $this->db->where('a.cheque_date >=', $start_date);
            $this->db->where('a.cheque_date <=', $end_date);
        }
    }
    if ($taxChoice == 'All') {
        $this->db->where("(TRIM(d.tax_type) = 'state_tax' OR TRIM(d.tax_type) = 'living_state_tax')");
    } elseif (trim($taxChoice) == 'state_tax') {
        $this->db->where("TRIM(d.tax_type)", 'state_tax');
    } elseif (trim($taxChoice) == 'living_state_tax') {
        $this->db->where("TRIM(d.tax_type)", 'living_state_tax');
    }
    $this->db->where('a.create_by', $user_id);
    $this->db->group_by('a.timesheet_id, d.code,a.cheque_date,  c.id, c.first_name, c.middle_name, c.last_name, d.tax_type, d.tax,d.amount');
    $query = $this->db->get();
   // echo $this->db->last_query(); die();
    return $query->result_array();
}

// New Federal Overall Summary - Madhu
public function getPaginatedSocialTaxSummary($limit, $offset, $orderField, $orderDirection, $search, $date = null, $emp_name = 'All')
{
    $user_id = $this->session->userdata("user_id");

    $subquery = "(SELECT DISTINCT b.timesheet_id FROM info_payslip b JOIN timesheet_info a ON a.timesheet_id = b.timesheet_id WHERE b.create_by = '$user_id'";
    
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }

    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
    }

    $subquery .= ")";

    $this->db->select('b.timesheet_id, b.f_tax AS f_ftax, b.m_tax AS m_mtax, b.s_tax AS s_stax, b.u_tax AS u_utax, b.templ_name, c.*, a.*');
    $this->db->from('info_payslip b');
    $this->db->join('employee_history c', 'c.id = b.templ_name');
    $this->db->join('timesheet_info a', 'a.timesheet_id = b.timesheet_id');
    $this->db->where("b.timesheet_id IN $subquery", NULL, FALSE);
    $this->db->where("b.create_by", $user_id);

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->or_like("c.first_name", $search);
        $this->db->or_like("c.last_name", $search);
        $this->db->or_like("c.middle_name", $search);
        $this->db->or_like("c.employee_tax", $search);
        $this->db->group_end();
    }

    $this->db->limit($limit, $offset);
    $this->db->order_by($orderField, $orderDirection);

    $query = $this->db->get();
    if ($query === false) {
        return false;
    }

    $result = $query->result_array();
    if (count($result) > 0) {
        $sums = array();
        foreach ($result as $row) { 
            $employee_id = $row['templ_name'];

            if (!isset($sums[$employee_id])) {
                $sums[$employee_id] = array(
                    'employee_id' => $employee_id,
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'employee_tax' => $row['employee_tax'],
                    'cheque_date' => $row['cheque_date'],
                    'total_s_tax' => 0,
                    'total_m_tax' => 0,
                    'total_u_tax' => 0,
                    'total_f_tax' => 0
                );
            }
            
            $sums[$employee_id]['total_s_tax'] += $row['s_stax'];
            $sums[$employee_id]['total_m_tax'] += $row['m_mtax'];
            $sums[$employee_id]['total_u_tax'] += $row['u_utax'];
            $sums[$employee_id]['total_f_tax'] += $row['f_ftax'];
        }
        return array_values($sums);
    }

    return false;
}

// Total Federal Overall Tax - Madhu
public function getSocialOveralltax($search, $date, $emp_name = 'All')
{
    $user_id = $this->session->userdata("user_id");

    $subquery = "(SELECT DISTINCT b.timesheet_id FROM info_payslip b JOIN timesheet_info a ON a.timesheet_id = b.timesheet_id WHERE b.create_by = '$user_id'";
    
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }

    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
    }

    $subquery .= ")";

    $this->db->select('first_name, middle_name, last_name');
    $this->db->from('employee_history');
    $this->db->where("create_by", $user_id);

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->or_like("first_name", $search);
        $this->db->or_like("last_name", $search);
        $this->db->or_like("middle_name", $search);
        $this->db->or_like("employee_tax", $search);
        $this->db->group_end();
    }

    $this->db->where("create_by", $user_id);

    $query = $this->db->get();

    if ($query === false) {
        return false;
    }

    return $query->num_rows();
}


public function sc_get_data_pay($d1 = null, $empid, $timesheetid) {
            if ($d1 === null || $empid === null || $timesheetid === null) {
                return false;  
            }
            $this->db->select("SUM(tax_history.s_tax) as s_s_tax, SUM(tax_history.m_tax) as s_m_tax, SUM(tax_history.u_tax) as s_u_tax, SUM(tax_history.f_tax) as s_f_tax, SUM(tax_history.sales_c_amount) as S_sales_c_amount");
            $this->db->from('tax_history');
            $this->db->join('timesheet_info', 'timesheet_info.timesheet_id = tax_history.time_sheet_id');
            $this->db->where('timesheet_info.create_by', $this->session->userdata('user_id'));
            $this->db->where('tax_history.tax', 'Income tax');
            $this->db->where('tax_history.employee_id', $empid);
            $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
            $this->db->group_by('timesheet_info.create_by');
            $query = $this->db->get();
             if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        }
public function get_f1099nec_info($selectedValue)
      {
          $user_id = $this->session->userdata('user_id');
          $this->db->select("employee_history.*,tax_history.sales_c_amount ,  SUM(tax_history.sales_c_amount) as  sumofsc ,  SUM(tax_history.f_tax) as  sumofftax ,SUM(tax_history.amount) as  sumofamount ");
          $this->db->from('employee_history');
          $this->db->join('tax_history', 'employee_history.id = tax_history.employee_id');
          $this->db->where('employee_history.create_by', $user_id);
          $this->db->where('employee_history.id', $selectedValue);
          $this->db->where('tax_history.tax', 'Income tax');
          $this->db->where('tax_history.tax_type', 'state_tax');
          $query = $this->db->get();
           if ($query !== false && $query->num_rows() > 0) {
              return $query->result_array();
          }
          return false;
      }
      public function no_salecommission($selectedValue)
      {
          $user_id = $this->session->userdata('user_id');
          $this->db->select("SUM(extra_thisrate) as sc_nocomission");
          $this->db->from('timesheet_info');
          $this->db->where('timesheet_info.create_by', $user_id);
          $this->db->where('templ_name', $selectedValue);
          $query = $this->db->get();
             if ($query !== false && $query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        }
        public function emp_yes_salecommission($selectedValue)
        {
            $this->load->library('session'); // Ensure session library is loaded if not already loaded
            $user_id = $this->session->userdata('user_id');
            $this->db->select("SUM(b.extra_thisrate) as emp_sc_amount");
            $this->db->from('employee_history AS a'); // Added space between table name and alias
            $this->db->join('timesheet_info AS b', 'b.templ_name = a.id'); // Corrected table alias
            $this->db->where('a.choice', 'No'); // Changed 'No' to 'Yes'
            $this->db->where('a.sales_partner', 'Sales_Partner'); // Ensure you reference the correct table alias
            $this->db->where('b.templ_name', $selectedValue);
            $query = $this->db->get();
            if ($query !== false && $query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        }
        public function get_data_salespartner()
        {
            $user_id = $this->session->userdata('user_id');
            $this->db->select('*');
            $this->db->from('timesheet_info a');
            $this->db->join('employee_history b', 'b.id = a.templ_name', 'left'); 
            $this->db->where('b.choice','No');
            $this->db->where('a.create_by', $user_id); 
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
            return [];
            }
        }

public function state_summary_employer($emp_name = null, $tax_choice = null, $selectState = null, $date = null, $taxType = null)
{
    $user_id = $this->session->userdata('user_id');
   $this->db->select('DISTINCT a.timesheet_id, SUM(b.total_amount) as gross , SUM(b.net_amount) as net,a.cheque_date, d.code, c.id, c.first_name, c.middle_name, c.last_name, d.tax_type, d.tax,d.weekly,d.biweekly,d.monthly, (d.amount) as total_amount', false);
    $this->db->from('timesheet_info a');
    $this->db->join('info_payslip b', 'b.templ_name = a.templ_name');
    $this->db->join('employee_history c', 'c.id = b.templ_name');
    $this->db->join('tax_history d', 'd.time_sheet_id = a.timesheet_id', 'left');
   $this->db->where("TRIM(d.tax_type) != 'local_tax'");
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date =$dates[1];
        $this->db->where('a.cheque_date >=', $start_date);
        $this->db->where('a.cheque_date <=', $end_date);
    }
    if ($taxType !== '') {
        $trimmed_taxType = trim($taxType);
        $this->db->like("TRIM(d.tax)", $trimmed_taxType, 'none');
    }
    if ($tax_choice == 'All') {
        $this->db->where("(TRIM(d.tax_type) = 'state_tax' OR TRIM(d.tax_type) = 'living_state_tax')");
    } elseif (trim($tax_choice) == 'state_tax') {
        $this->db->where("TRIM(d.tax_type)", 'state_tax');
    } elseif (trim($tax_choice) == 'living_state_tax') {
        $this->db->where("TRIM(d.tax_type)", 'living_state_tax');
    }
    if ($selectState !== '') {
        $trimmed_selectState = trim($selectState);
        $this->db->where("TRIM(d.code)", $trimmed_selectState);
    }
       if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.create_by', $user_id);
    $this->db->group_by('a.timesheet_id,d.code, c.id, c.first_name, c.middle_name, c.last_name, d.tax_type,d.weekly,d.biweekly,d.monthly, d.tax,d.amount');
    
    $query = $this->db->get();
   
    $resultRows = $query->result_array();
   
    return $resultRows;
}

// Old State Tax Report - Madhu
public function statetaxreport($employee_name=null,$url,$date=null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,a.weekly,a.biweekly,a.monthly,c.*');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'state_tax'); $this->db->order_by('a.tax', 'ASC');
    
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }

  if ($employee_name !== 'All' && $employee_name !== null) {
        $trimmed_emp_name = trim($employee_name);
        $this->db->group_start();
        $this->db->like("TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name))", $trimmed_emp_name);
        $this->db->or_like("TRIM(CONCAT_WS(' ', c.first_name, c.last_name))", $trimmed_emp_name);
        $this->db->group_end();
    }
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $url);
    $query = $this->db->get();
    return $query->result_array();
}

// New State Tax Report - Madhu
public function state_tax_report($limit, $start, $orderField, $orderDirection, $search, $taxname, $date, $employee_name='All')
{
    $user_id = $this->session->userdata('user_id');

    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }

    if ($employee_name !== 'All' && $employee_name !== null) {
        $trimmed_emp_name = trim($employee_name);
        $this->db->group_start();
        $this->db->like("TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name))", $trimmed_emp_name);
        $this->db->or_like("TRIM(CONCAT_WS(' ', c.first_name, c.last_name))", $trimmed_emp_name);
        $this->db->group_end();
    }

    $this->db->select('a.tax, a.tax_type, a.time_sheet_id, d.month, d.cheque_date, a.amount, a.weekly, a.biweekly, a.monthly, c.*');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->join('info_payslip b', 'a.time_sheet_id = b.timesheet_id', 'left'); 

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("d.timesheet_id", $search);
        $this->db->or_like("c.first_name", $search);
        $this->db->or_like("c.last_name", $search);
        $this->db->or_like("c.middle_name", $search);
        $this->db->or_like("c.employee_tax", $search);
        $this->db->like("d.month", $search);
        $this->db->group_end();
    }

    if ($taxname) {
        $this->db->where('a.tax', $taxname);
    }

    $this->db->where('a.tax_type', 'state_tax');
    $this->db->where('b.create_by', $user_id); 
    $this->db->distinct();
    $this->db->limit($limit, $start);
    $this->db->order_by($orderField, $orderDirection);

    $query = $this->db->get();

    if (!$query) {
        $error = $this->db->error(); 
        echo 'Query failed: ' . $error['message']; 
        exit;
    }

    return $query->result_array();
}

// Total Income Tax - Madhu
public function getTotalIncomeTax($search, $date, $employee_name = 'All')
{
    $user_id = $this->session->userdata("user_id");

    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }

    if ($employee_name !== 'All' && $employee_name !== null) {
        $trimmed_emp_name = trim($employee_name);
        $this->db->group_start();
        $this->db->like("TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name))", $trimmed_emp_name);
        $this->db->or_like("TRIM(CONCAT_WS(' ', c.first_name, c.last_name))", $trimmed_emp_name);
        $this->db->group_end();
    }

    $this->db->select('a.tax, a.tax_type, a.time_sheet_id, d.month, a.amount, a.weekly, a.biweekly, a.monthly, c.*');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->join('info_payslip b', 'a.time_sheet_id = b.timesheet_id', 'left'); 
    $this->db->where('a.tax_type', 'state_tax');

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("b.timesheet_id", $search);
        $this->db->or_like("c.first_name", $search);
        $this->db->or_like("c.last_name", $search);
        $this->db->or_like("c.middle_name", $search);
        $this->db->or_like("c.employee_tax", $search);
        $this->db->group_end();
    }

    $this->db->where('b.create_by', $user_id); 

    $query = $this->db->get();

    if ($query === false) {
        return false;
    }

    return $query->num_rows();
}

public function other_tax_report(){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'other_working_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $query = $this->db->get();
    return $query->result_array();
}
public function other_tax_employer_report(){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'other_working_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $query = $this->db->get();
    return $query->result_array();
}
public function other_tax_report_search($emp_name=null,$date=null){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'other_working_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
  if ($date) {
        $dates = explode(' to ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("STR_TO_DATE(d.start, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(d.end, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->where("STR_TO_DATE(d.end, '%m/%d/%Y') <= STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->group_end();
    }
    if ($emp_name !== 'Any') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
    $query = $this->db->get();
    return $query->result_array();
}
public function other_tax_employer_report_search($emp_name=null,$date=null){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'other_working_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("STR_TO_DATE(d.start, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(d.end, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->where("STR_TO_DATE(d.end, '%m/%d/%Y') <= STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->group_end();
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
    $query = $this->db->get();
    return $query->result_array();
}
public function working_state_tax_report_search($tax_name = null, $emp_name = null, $date = null)
{
  $user_id = $this->session->userdata('user_id');
  $this->db->select('tax_history.*, c.*, d.*, tax, tax_type, time_sheet_id, month, amount, first_name, last_name');
  $this->db->from('tax_history'); 
  $this->db->join('employee_history c', 'c.id = tax_history.employee_id');
  $this->db->join('timesheet_info d', 'tax_history.time_sheet_id = d.timesheet_id');
  $this->db->where('tax_type', 'state_tax');
  $this->db->where('created_by', $user_id);
  $this->db->where('tax', $tax_name);
 $this->db->order_by('tax', 'ASC');
  if ($date) {
    $dates = explode(' - ', $date);
    $start_date = date('m/d/Y', strtotime($dates[0]));
    $end_date = date('m/d/Y', strtotime($dates[1]));
    $this->db->group_start();
    $this->db->where("(d.start BETWEEN '$start_date' AND '$end_date')");
    $this->db->or_where("(d.end BETWEEN '$start_date' AND '$end_date')");
    $this->db->where("(d.end <= '$end_date')");
    $this->db->group_end();
  }
  if ($emp_name !== 'All') {
    $trimmed_emp_name = trim($emp_name);
    $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
  }
  $this->db->group_by('time_sheet_id');
  $query = $this->db->get();
  return $query->result_array();
}
public function living_state_tax_report_search($tax_name=null,$emp_name=null,$date=null){
     $user_id = $this->session->userdata('user_id');
    $this->db->select('a.*,c.*,d.*,a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'living_state_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $tax_name); $this->db->order_by('tax', 'ASC');
if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("(d.start) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->or_where("(d.end) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->where("(d.end) <= ('$end_date')");
        $this->db->group_end();
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
    $query = $this->db->get();
    return $query->result_array();
}
public function working_state_tax_report_search_employer($tax_name=null,$emp_name=null,$date=null){
     $user_id = $this->session->userdata('user_id');
    $this->db->select('a.*,c.*,d.*,a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'state_tax'); $this->db->order_by('tax', 'ASC');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $tax_name); $this->db->order_by('tax', 'ASC');
if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("(d.start) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->or_where("(d.end) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->where("(d.end) <= ('$end_date')");
        $this->db->group_end();
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
    $query = $this->db->get();
    return $query->result_array();
}
public function bankdataDetails()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('bank_add');
    $this->db->where('created_by', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
   }
}
public function get_employeeTypedata()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('employee_type');
    $this->db->where('created_by', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
   }
}
public function living_state_tax_report_search_employer($tax_name=null,$emp_name=null,$date=null){
     $user_id = $this->session->userdata('user_id');
    $this->db->select('a.*,c.*,d.*,a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
      $this->db->where('a.tax_type', 'living_state_tax');
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $tax_name);$this->db->order_by('tax', 'ASC');
if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("(d.start) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->or_where("(d.end) BETWEEN ('$start_date') AND ('$end_date')");
        $this->db->where("(d.end) <= ('$end_date')");
        $this->db->group_end();
    }
      if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $query = $this->db->get();
    return $query->result_array();
}

public function living_state_tax_report($employee_name=null,$url, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    
    $this->db->select('a.tax, a.tax_type, a.time_sheet_id, d.month, a.amount, c.first_name, c.last_name');
    $this->db->from('tax_history a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'living_state_tax');
    $this->db->order_by('a.tax', 'ASC');
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }
   if ($employee_name !== 'All') {
        $trimmed_emp_name = trim($employee_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.created_by', $user_id);
    $this->db->where('a.tax', $url);

    $query = $this->db->get();
    return $query->result_array();
}

public function employer_state_tax_report($employee_name=null,$url,$date=null )
{
    if(trim($url) != 'Income tax'){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'state_tax');$this->db->order_by('a.tax', 'ASC');
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $url);
    $query = $this->db->get();
    return $query->result_array();
    }
}

public function get_data_pay_partner($d1=null,$empid,$timesheetid){
    $this->db->select('sum(extra_thisrate) as amount , job_title');
    $this->db->from('timesheet_info');
    $this->db->where('templ_name',$empid);
    $this->db->where('create_by', $this->session->userdata('user_id'));
  $this->db->where('month <=', date('Y-m-d'));
$this->db->where("STR_TO_DATE(SUBSTRING_INDEX(month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
  $this->db->group_by('job_title');
    $query = $this->db->get(); 
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
        }
        public function get_data_pay_SalesCommission($d1=null,$empid,$timesheetid){
    $this->db->select('sum(extra_thisrate) as amount , job_title');
    $this->db->from('timesheet_info');
    $this->db->where('templ_name',$empid);
    $this->db->where('create_by', $this->session->userdata('user_id'));
  $this->db->where('month <=', date('Y-m-d'));
$this->db->where("STR_TO_DATE(SUBSTRING_INDEX(month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
  $this->db->group_by('job_title');
    $query = $this->db->get(); 
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}

public function employer_living_state_tax_report($employee_name=null,$url,$date=null)
{
    if(trim($url) != 'Income tax'){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('a.tax,a.tax_type,a.time_sheet_id,d.month,a.amount,c.first_name,c.last_name');
    $this->db->from('tax_history_employer a');
    $this->db->join('employee_history c', 'c.id = a.employee_id');
    $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
    $this->db->where('a.tax_type', 'living_state_tax');$this->db->order_by('a.tax', 'ASC');

    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $this->db->where("d.cheque_date BETWEEN '$start_date' AND '$end_date'");
    }
    
    if ($employee_name !== 'All') {
        $trimmed_emp_name = trim($employee_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.created_by', $this->session->userdata('user_id'));
    $this->db->where('a.tax', $url);
    $query = $this->db->get();
    return $query->result_array();
    }
}

public function citydelete_tax($citytax = null, $city) {
    $this->db->where('tax', $city . '-' . $citytax);
    $this->db->where('created_by', $this->session->userdata('user_id'));
    $this->db->where('Type', 'City'); 
    $this->db->delete('state_and_tax');
    if ($citytax) {
        $sql = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ?, ''), ',', ',') WHERE created_by=? AND state=? AND Type='City'";
        $query = $this->db->query($sql, array($citytax, $this->session->userdata('user_id'), $city));
    } else {
        $this->db->where('state', $city);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->where('Type', 'City'); 
        $this->db->delete('state_and_tax');
    }
    $sql1 = "UPDATE state_and_tax SET tax = TRIM(BOTH ',' FROM tax) WHERE Type='City'";
     $query1 = $this->db->query($sql1);
    $sql3 = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ',,', ','), ',', ',') WHERE created_by=? AND state=? AND Type='City'";
    $query3 = $this->db->query($sql3, array($this->session->userdata('user_id'), $city));
     return true;
}
public function federal_tax_report($emp_name = null, $date = null, $status = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('SUBSTRING_INDEX(ti.start, " - ", 1) AS start');
    $this->db->select('SUBSTRING_INDEX(ti.end, " - ", -1) AS end');
    $this->db->select('ti.month');
    $this->db->select('c.*');
    $this->db->select('b.f_tax AS f_ftax');
    $this->db->select('b.m_tax AS m_mtax');
    $this->db->select('b.s_tax AS s_stax');
    $this->db->select('b.u_tax AS u_utax');
    $this->db->select('ti.timesheet_id AS timesheet');
    $this->db->from('timesheet_info ti');
    $this->db->join('info_payslip b', 'b.timesheet_id = ti.timesheet_id', 'left');
    $this->db->join('employee_history c', 'c.id = b.templ_name', 'inner');
    if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("STR_TO_DATE(ti.start, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(ti.end, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(ti.start, '%m/%d/%Y') <= STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE(ti.end, '%m/%d/%Y') >= STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->group_end();
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('ti.create_by', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function so_tax_report_employee($employee_name = null, $date = null, $status = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('c.id,c.first_name,(ti.above_extra_sum) as gross,(b.net_amount) as net, c.middle_name, c.last_name, c.employee_tax, ti.cheque_date');
    $this->db->select('(b.f_tax) AS fftax');
    $this->db->select('(b.m_tax) AS mmtax');
    $this->db->select('(b.s_tax) AS sstax');
    $this->db->select('(b.u_tax) AS uutax');
    $this->db->from('timesheet_info ti');
    
    $this->db->join('info_payslip b', 'b.timesheet_id = ti.timesheet_id', 'left');
    $this->db->join('employee_history c', 'c.id = b.templ_name', 'inner');
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date =$dates[1];
        $this->db->where('ti.cheque_date >=', $start_date);
        $this->db->where('ti.cheque_date <=', $end_date);
    }
   if ($employee_name !== 'All') {
        $trimmed_emp_name = trim($employee_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('ti.create_by', $user_id);
    $this->db->where('ti.uneditable', '1');
    $this->db->order_by('c.id', 'ASC');
   
    $query = $this->db->get();
   
     if ($query->num_rows() > 0) {
        $resultRows = $query->result_array();

        // Maps to store summed gross and net for each employee
        $employeeSummary = [];

        // Loop through each row to accumulate sums for each employee
        foreach ($resultRows as $row) {
            $employeeId = $row['id'];
            $gross = $row['gross'];
            $net = $row['net'];

            // Initialize sums if not already done
            if (!isset($employeeSummary[$employeeId])) {
                $employeeSummary[$employeeId] = [
                    'id' => $employeeId,
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'employee_tax' => $row['employee_tax'],
                    'cheque_date' => $row['cheque_date'], // You may want to store the last date or another relevant date
                    'gross' => 0,
                    'net' => 0,
                    'fftax' => 0,
                    'mmtax' => 0,
                    'sstax' => 0,
                    'uutax' => 0,
                ];
            }

            // Accumulate gross and net
            $employeeSummary[$employeeId]['gross'] += $gross;
            $employeeSummary[$employeeId]['net'] += $net;

            // If you want to sum tax values, add them here as needed:
            $employeeSummary[$employeeId]['fftax'] += $row['fftax'];
            $employeeSummary[$employeeId]['mmtax'] += $row['mmtax'];
            $employeeSummary[$employeeId]['sstax'] += $row['sstax'];
            $employeeSummary[$employeeId]['uutax'] += $row['uutax'];
        }

        // Convert the associative array back to a numeric array
     
        return array_values($employeeSummary);
    }

    return false;
}

public function so_tax_report_employer($emp_name = null, $date = null, $status = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('c.first_name, c.middle_name, c.last_name ,c.id, c.employee_tax,ti.cheque_date');
    $this->db->select('(b.f_tax) AS fftax');
    $this->db->select('(b.m_tax) AS mmtax');
    $this->db->select('(b.s_tax) AS sstax');
    $this->db->select('(b.u_tax) AS uutax');
    $this->db->from('tax_history_employer b');
    $this->db->join('timesheet_info ti', 'b.time_sheet_id = ti.timesheet_id', 'left');
    $this->db->join('employee_history c', 'c.id = b.employee_id', 'inner');
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date =$dates[1];
        $this->db->where('ti.cheque_date >=', $start_date);
        $this->db->where('ti.cheque_date <=', $end_date);
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('ti.uneditable', '1');
    $this->db->where('ti.create_by', $user_id);
     $this->db->order_by('c.id', 'ASC');
    $this->db->group_by('c.id,c.first_name, c.middle_name, c.last_name, c.employee_tax,ti.start,ti.end,b.f_tax,b.m_tax,b.s_tax,b.u_tax,ti.cheque_date');
    
     $query = $this->db->get();
    //echo $this->db->last_query();die();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}



public function federal_tax()
{
    $user_id = $this->session->userdata('user_id');
$this->db->select('a.timesheet_id, b.f_tax, c.first_name, c.middle_name, c.last_name, c.employee_tax, a.month');
$this->db->from('timesheet_info a');
$this->db->join('info_payslip b', 'b.templ_name = a.templ_name AND b.timesheet_id = a.timesheet_id');
$this->db->join('employee_history c', 'c.id = b.templ_name');
$this->db->where('a.create_by',  $user_id);
$this->db->group_by('a.timesheet_id, b.f_tax, c.first_name, c.middle_name, c.last_name, c.employee_tax, a.month');
$query = $this->db->get();
   if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function stateTaxlist()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->distinct();
    $this->db->where('tax_type', 'state_tax');
    $this->db->where('created_by', $user_id);
    $this->db->order_by('tax', 'ASC');
    $query = $this->db->get('tax_history');
    if ($query->num_rows() > 0) {
        return $query->result_array();
   }
}
public function social_tax_report($emp_name = null, $tax_choice = null, $selectState = null, $taxType = null, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('d.time_sheet_id,c.first_name,c.middle_name,c.last_name, d.amount');
$this->db->from('timesheet_info a');
$this->db->join('info_payslip b', 'b.templ_name = a.templ_name');
$this->db->join('employee_history c', 'c.id = b.templ_name');
$this->db->join('tax_history_employer d', 'd.time_sheet_id = a.timesheet_id', 'left');
  if ($date) {
  $dates = explode(' - ', $date);
$this->db->where("(a.start BETWEEN '$dates[0]' AND '$dates[1]' OR a.end BETWEEN '$dates[0]' AND '$dates[1]' AND a.end <= '$dates[1]')");
}
  if ($tax_choice =='living_state_tax') {
 $this->db->like("TRIM(d.tax_type)", 'living_state_tax', 'both', false);
}
if ($selectState !== '') {
        $trimmed_selectState = trim($selectState);
        $this->db->like("TRIM(CONCAT(d.code))", $trimmed_selectState);
    }
  if ($taxType !== '') {
        $trimmed_taxType = trim($taxType);
        $this->db->like("TRIM(d.tax)", $trimmed_taxType, 'both', false);
    }
    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.middle_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.create_by', $user_id);
$this->db->group_by('c.first_name,c.middle_name,c.last_name, d.time_sheet_id, d.amount');
$query = $this->db->get();
$resultRows = [];
foreach ($query->result_array() as $row) {
    $templ_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    if (isset($resultRows[$templ_name])) {
        $resultRows[$templ_name]['totalAmount'] += $row['amount'];
    } else {
        $resultRows[$templ_name] = [
            'templ_name' => $templ_name,
            'totalAmount' => $row['amount']
        ];
    }
}
$resultRows = array_values($resultRows);
return $resultRows;
}
public function social_tax_employee_report($emp_name = null, $tax_choice = null, $selectState = null, $taxType = null, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('d.time_sheet_id, c.first_name,c.middle_name,c.last_name, d.amount');
$this->db->from('timesheet_info a');
$this->db->join('info_payslip b', 'b.templ_name = a.templ_name');
$this->db->join('employee_history c', 'c.id = b.templ_name');
$this->db->join('tax_history  d', 'd.time_sheet_id = a.timesheet_id', 'left');
if ($date) {
        $dates = explode(' - ', $date);
$this->db->where("(a.start BETWEEN '$dates[0]' AND '$dates[1]' OR a.end BETWEEN '$dates[0]' AND '$dates[1]' AND a.end <= '$dates[1]')");
}
  if ($tax_choice =='living_state_tax') {
 $this->db->like("TRIM(d.tax_type)", 'living_state_tax', 'both', false);
}
  if ($selectState !== '') {
        $trimmed_selectState = trim($selectState);
        $this->db->like("TRIM(CONCAT(d.code))", $trimmed_selectState);
    }
  if ($taxType !== '') {
        $trimmed_taxType = trim($taxType);
        $this->db->like("TRIM(d.tax)", $trimmed_taxType, 'both', false);
    }
    if ($emp_name !== 'Any') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("CONCAT(TRIM(c.first_name), ' ', TRIM(c.last_name))", $trimmed_emp_name, 'both', false);
    }
    $this->db->where('a.create_by', $user_id);
$this->db->group_by('c.first_name,c.middle_name,c.last_name, d.time_sheet_id, d.amount');
$query = $this->db->get();
$resultRows = [];
foreach ($query->result_array() as $row) {
    $templ_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    if (isset($resultRows[$templ_name])) {
        $resultRows[$templ_name]['totalAmountEmployee'] += $row['amount'];
    } else {
        $resultRows[$templ_name] = [
            'templ_name' => $templ_name,
            'totalAmountEmployee' => $row['amount']
        ];
    }
}
$resultRows = array_values($resultRows);
return $resultRows;
}

// Old Social Tax Summary
public function social_tax_sumary($date = null, $emp_name = 'All')
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('b.*,c.*,b.timesheet_id,d.*');
    $this->db->from('info_payslip b');
    $this->db->join('employee_history c', 'c.id = b.templ_name');
    $this->db->join('timesheet_info d', 'd.templ_name = c.id');
    $this->db->where('d.uneditable', 1);
    $this->db->where('b.create_by', $user_id);
    $this->db->group_by('b.timesheet_id'); 
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $subquery .= " AND (d.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }

    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
    }
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $result = $query->result_array();
        $sums = array();
        foreach ($result as $row) {
            $employee_id = $row['templ_name'];
           // echo $employee_id;
            if (!isset($sums[$employee_id])) {
                $sums[$employee_id] = array(
                    'employee_id' => $employee_id,
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'total_s_tax' => 0,
                    'total_m_tax' => 0,
                    'total_u_tax' => 0,
                    'total_f_tax' => 0
                );
            }
            $sums[$employee_id]['s_stax_sum'] += $row['s_tax'];
            $sums[$employee_id]['m_mtax_sum'] += $row['m_tax'];
            $sums[$employee_id]['u_utax_sum'] += $row['u_tax'];
            $sums[$employee_id]['f_ftax_sum'] += $row['f_tax'];
        }
        return array_values($sums);
    }
    return false;
}

public function social_tax()
{
         $user_id = $this->session->userdata('user_id');
$query = $this->db->select('a.timesheet_id')
                  ->select('a.*')
                  ->select('b.*')
                  ->select('c.*')
                  ->select('b.f_tax as f_ftax')
                  ->select('b.m_tax as m_mtax')
                  ->select('b.s_tax as s_stax')
                  ->select('b.u_tax as u_utax')
                  ->select('d.s_tax as stax')
                  ->select('d.m_tax as mtax')
                  ->select('d.f_tax as ftax')
                  ->select('d.u_tax as utax')
                  ->from('timesheet_info a')
                  ->join('info_payslip b', 'b.templ_name = a.templ_name')
                  ->join('employee_history c', 'c.id = b.templ_name')
                  ->join('tax_history_employer d', 'd.time_sheet_id = a.timesheet_id', 'left')
                  ->where('a.create_by', $user_id)
                  ->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function so_total_amount($selectedValue)
{
         $user_id = $this->session->userdata('user_id');
$query = $this->db->select('(b.total_amount) as tamount,a.timesheet_id')
                 ->from('timesheet_info a')
                  ->join('info_payslip b', 'b.templ_name = a.templ_name')
                  ->join('employee_history c', 'c.id = b.templ_name')
                  ->join('tax_history_employer d', 'd.time_sheet_id = a.timesheet_id', 'left')
                  ->where('a.create_by', $user_id)
                  ->where('a.quarter', $selectedValue)
                   ->group_by('b.total_amount,a.timesheet_id')
                  ->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}

// Federal Overall Social Tax - Madhu
public function social_tax_employer($date = null, $emp_name = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('b.*,c.*,b.time_sheet_id, d.*');
    $this->db->from('tax_history_employer b');
    $this->db->join('employee_history c', 'c.id = b.employee_id');
    $this->db->join('timesheet_info d', 'd.templ_name = c.id');
    $this->db->where('d.uneditable', 1);
    $this->db->where('b.created_by', $user_id);
    $this->db->group_by('b.time_sheet_id');

    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];
        $subquery .= " AND (d.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }

    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
    }

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $result = $query->result_array();
        $sums = array();
        foreach ($result as $row) {
            $employee_id = $row['employee_id'];
            if (!isset($sums[$employee_id])) {
                $sums[$employee_id] = array(
                    'employee_id' => $employee_id,
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'total_s_tax' => 0,
                    'total_m_tax' => 0,
                    'total_u_tax' => 0,
                    'total_f_tax' => 0
                );
            }
            // Sum taxes for each employee
            $sums[$employee_id]['s_stax_sum_er'] += $row['s_tax'];
            $sums[$employee_id]['m_mtax_sum_er'] += $row['m_tax'];
            $sums[$employee_id]['u_utax_sum_er'] += $row['u_tax'];
            $sums[$employee_id]['f_ftax_sum_er'] += $row['f_tax'];
        }
        return array_values($sums);
        return false;
    }
}

public function employe($emp_name = null, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    $subquery = "(SELECT DISTINCT b.timesheet_id 
                 FROM info_payslip b 
                 JOIN timesheet_info a ON a.timesheet_id = b.timesheet_id 
                 WHERE b.create_by = '$user_id'";

    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];  
        $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }

    if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' 
                        OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
    }
    $subquery .= ")";
    $this->db->select('a.month, b.timesheet_id, c.employee_tax, b.templ_name, c.first_name, c.middle_name, c.last_name, 
        b.f_tax AS f_ftax, b.m_tax AS m_mtax, b.s_tax AS s_stax, b.u_tax AS u_utax');
    $this->db->from('info_payslip b');
    $this->db->join('employee_history c', 'c.id = b.templ_name');
    $this->db->join('timesheet_info a', 'a.timesheet_id = b.timesheet_id');
    $this->db->where("b.timesheet_id IN $subquery", NULL, FALSE);
    $this->db->order_by('b.timesheet_id', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
}

public function employr($emp_name = null, $date = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->distinct(); 
    $this->db->select('b.f_tax AS f_ftax, b.m_tax AS m_mtax, b.s_tax AS s_stax, b.u_tax AS u_utax,c.employee_tax,b.time_sheet_id as timesheet, c.first_name, c.middle_name, c.last_name'); 
    $this->db->from('tax_history_employer b');
    $this->db->join('employee_history c', 'c.id = b.employee_id');
    $this->db->join('timesheet_info a', 'a.timesheet_id = b.time_sheet_id');
    $this->db->where('b.created_by', $user_id);
    $this->db->order_by('b.time_sheet_id', 'ASC');
    $this->db->group_by('b.f_tax, b.m_tax, b.s_tax, b.u_tax,b.time_sheet_id, c.first_name, c.middle_name, c.last_name,c.employee_tax');

     if ($emp_name !== 'All') {
        $trimmed_emp_name = trim($emp_name);
        $this->db->group_start();
        $this->db->like("TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name))", $trimmed_emp_name);
        $this->db->or_like("TRIM(CONCAT_WS(' ', c.first_name, c.last_name))", $trimmed_emp_name);
        $this->db->group_end();
    }
    if ($date) {
        $dates = explode(' to ', $date);
        $start_date = $dates[0];
        $end_date = $dates[1];  
        $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
    }
    
    $query = $this->db->get();

    return $query->result_array();
}

public function getEmployeeContributions($emp_name = null, $date = null){
        $this->db->select('a.time_sheet_id,d.month,a.amount,c.*');
        $this->db->from('tax_history a');
          $this->db->join('employee_history c', 'c.id = a.employee_id');
           $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
          if ($emp_name !== 'Any') {
        $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("STR_TO_DATE(d.start, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(d.end, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->where("STR_TO_DATE(d.end, '%m/%d/%Y') <= STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->group_end();
    }
 $this->db->where('a.created_by',$this->session->userdata('user_id'));
   $this->db->where_in('a.tax_type',  'living_county_tax');
        $query = $this->db->get();
        return $query->result_array();
    }
public function getEmployeeContributions_local($emp_name = null, $date = null){
        $this->db->select('a.time_sheet_id,d.month,a.amount,c.*');
        $this->db->from('tax_history a');
          $this->db->join('employee_history c', 'c.id = a.employee_id');
           $this->db->join('timesheet_info d', 'a.time_sheet_id = d.timesheet_id');
           if ($date) {
        $dates = explode(' - ', $date);
        $start_date = date('m/d/Y', strtotime($dates[0]));
        $end_date = date('m/d/Y', strtotime($dates[1]));
        $this->db->group_start();
        $this->db->where("STR_TO_DATE(d.start, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->or_where("STR_TO_DATE(d.end, '%m/%d/%Y') BETWEEN STR_TO_DATE('$start_date', '%m/%d/%Y') AND STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->where("STR_TO_DATE(d.end, '%m/%d/%Y') <= STR_TO_DATE('$end_date', '%m/%d/%Y')");
        $this->db->group_end();
    }
           if ($emp_name !== 'Any') {
     $trimmed_emp_name = trim($emp_name); 
        $this->db->like("TRIM(CONCAT(c.first_name, ' ', c.last_name))", $trimmed_emp_name);
    }
 $this->db->where('a.created_by',$this->session->userdata('user_id'));
   $this->db->where_in('a.tax_type',  'living_local_tax');
        $query = $this->db->get();
 return $query->result_array(); 
    }
public function countydelete_tax($countytax = null, $county) {
    $this->db->where('tax', $county . '-' . $countytax);
    $this->db->where('created_by', $this->session->userdata('user_id'));
    $this->db->where('Type', 'County');
    $this->db->delete('state_and_tax');
    if ($countytax) {
        $sql = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ?, ''), ',', ',') WHERE created_by=? AND state=? AND Type='County'";
        $query = $this->db->query($sql, array($countytax, $this->session->userdata('user_id'), $county));
    } else {
        $this->db->where('state', $county);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->where('Type', 'County');
        $this->db->delete('state_and_tax');
    }
    $sql1 = "UPDATE state_and_tax SET tax = TRIM(BOTH ',' FROM tax) WHERE Type='County'";
    $query1 = $this->db->query($sql1);
    $sql3 = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ',,', ','), ',', ',') WHERE created_by=? AND state=? AND Type='County'";
    $query3 = $this->db->query($sql3, array($this->session->userdata('user_id'), $county));
    return true;
}
public function get_info_city_tax(){
      $this->db->select('*');
           $this->db->from('state_and_tax');
           $this->db->where('created_by',$this->session->userdata('user_id'));
           $this->db->where('Type','City');
           $query = $this->db->get();
           if ($query->num_rows() > 0) {
              return $query->result_array();
           }
            return true;
   }
public function get_info_county_tax(){
    $this->db->select('*');
         $this->db->from('state_and_tax');
         $this->db->where('created_by',$this->session->userdata('user_id'));
         $this->db->where('Type','County');
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
         }
          return true;
 }
  public function checkTimesheetInfo($employeeId, $selectedDate) {
        $this->db->where('templ_name', $employeeId);
        $this->db->like('month', $selectedDate, 'both'); 
        $query = $this->db->get('timesheet_info');
        return $query->num_rows() > 0;
    }
public function employee_bankDetails()
   {
        $this->db->select('*');
        $this->db->from('bank_add');
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
   }
public function state_tax(){
        $this->db->select('state');
        $this->db->from('state_and_tax');
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('Type','State');
        $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result_array();
        }
         return true;
         }

    public function employee_data_get() 
    {
        $this->db->select("ti.*, eh.*");
        $this->db->from('timesheet_info ti');
        $this->db->join('employee_history eh', 'eh.id = ti.templ_name');
        $this->db->where('ti.create_by', $this->session->userdata('user_id'));
        $this->db->group_by('eh.id');
        $query = $this->db->get();    
        return $query->result_array();
    }

    public function timesheet_data_get() {
        $this->db->select("*");
        $this->db->from('timesheet_info');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();    
        return $query->result_array();
    }
    public function expenses_data_get() {
        $this->db->select("*");
        $this->db->from('expense');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();    
        return $query->result_array();
    }
    public function officeloan_data_get() {
        $this->db->select("*");
        $this->db->from('person_ledger');
        $this->db->where('create_by', $this->session->userdata('user_id'));
        $query = $this->db->get();    
        return $query->result_array();
    }
       public function office_loan_list(){
        $this->db->select('*');
        $this->db->from('person_ledger');
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
    public function empl_data_info(){
        $this->db->select('*');
        $this->db->from('timesheet_info');
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
    public function federal_tax_info($employee_status,$final,$federal_range){
        $this->db->select('employee');
        $this->db->from('federal_tax');
        $this->db->where($employee_status,$federal_range);
       $query = $this->db->get();
      if ($query->num_rows() > 0) {
           return $query->result_array();
        }else{
  return 0;
        }
}
public function unemployment_tax_info($employee_status,$final,$unemployment_range){
    $this->db->select('employee,employer,details');
    $this->db->from('federal_tax');
    $this->db->where($employee_status,$unemployment_range);
   $query = $this->db->get();
         if ($query->num_rows() > 0) {
       return $query->result_array();
    }else{
return 0;
    }
}

 public function social_tax_info($employee_status,$final,$social_range){
        $this->db->select('employee,employer');
        $this->db->from('federal_tax');
        $this->db->where($employee_status,$social_range);
       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result_array();
        }
         return true;
}
public function  insert_taxesname($postData){
    $postData= str_replace("+"," ",$postData);
        $data1 = array( 
      'status' => 0
);
    $this->db->where('created_by',$this->session->userdata('user_id'));
$this->db->update('state_and_tax', $data1);
        $data=array(
            'status' => 1,
        );
        $this->db->where('state',$postData);
        $this->db->update('state_and_tax', $data);
    }
    public function Medicare_tax_info($employee_status,$final,$Medicare_range){
        $this->db->select('employee,employer');
        $this->db->from('federal_tax');
        $this->db->where($employee_status,$Medicare_range);
       $query = $this->db->get();
             if ($query->num_rows() > 0) {
           return $query->result_array();
        }else{
  return 0;
        }
}
public function get_overtime_data(){
    $this->db->select('*');
    $this->db->from('working_time');
    $this->db->where('created_by',$this->session->userdata('user_id'));
    $query = $this->db->get();
   if ($query->num_rows() > 0) {
     return $query->result_array();
   }
   return false;
}
public function get_data_pay($d1=null,$empid,$timesheetid){
    $this->db->select('timesheet_info.*, info_payslip.*, SUM(info_payslip.s_tax) as t_s_tax, SUM(info_payslip.m_tax) as t_m_tax, SUM(info_payslip.f_tax) as t_f_tax, SUM(info_payslip.u_tax) as t_u_tax, SUM(info_payslip.total_amount) as t_amount,SUM(info_payslip.sc) as sc, SUM(timesheet_info.total_hours) as t_hours ,     SUM(timesheet_info.extra_this_hour) as eth ,SUM(timesheet_info.extra_ytd) as ytdeth   ,   SUM(timesheet_info.above_this_hours) as above_eth , SUM(timesheet_info.extra_ytd) as ytdeth ,SUM(timesheet_info.above_extra_ytd) as above_ytdeth ');
    $this->db->from('timesheet_info');
    $this->db->join('info_payslip', 'timesheet_info.timesheet_id = info_payslip.timesheet_id');
    $this->db->where('info_payslip.templ_name',$empid);
    $this->db->where('info_payslip.create_by', $this->session->userdata('user_id'));
    $this->db->select('(SUM(info_payslip.total_amount) - SUM(info_payslip.sc)) as t_amount', FALSE);
    $this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE(' $d1', '%m/%d/%Y')", NULL, FALSE);
    $this->db->group_by('info_payslip.templ_name, info_payslip.create_by');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
        }
public function get_tax_info($d1=null,$empid,$timesheetid){
$this->db->select('tax, SUM(amount) as total_amount');
$this->db->from('tax_history');
$this->db->group_by('tax');
$this->db->join('timesheet_info', 'tax_history.time_sheet_id = timesheet_info.timesheet_id');
$this->db->where('tax_history.employee_id', $empid);
$this->db->where('tax_history.created_by', $this->session->userdata('user_id'));
$this->db->where("STR_TO_DATE(SUBSTRING_INDEX(timesheet_info.month, ' - ', -1), '%m/%d/%Y') <= STR_TO_DATE('$d1', '%m/%d/%Y')", NULL, FALSE);
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
          return $query->result();
        }
        return false;
}
 public function local_state_tax($employee_status,$final,$local_tax_range){
        $this->db->select('employee,employer');
        $this->db->from('state_localtax');
        $this->db->where($employee_status,$local_tax_range);
        $this->db->not_like('tax', 'Unemployment');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
        }
         return true;
 }
public function sc_info_count($templ_name, $payperiod) {
    $date = explode('-', $payperiod);
    $formattedStartDate = date('Y-m-d', strtotime($date[0]));
    $formattedendDate = date('Y-m-d', strtotime($date[1]));
    $this->db->select('b.sc,a.commercial_invoice_number ,a.gtotal');
    $this->db->from('invoice a');
    $this->db->join('employee_history b', 'a.user_emp_id = b.id');
    $this->db->join('payment c', 'a.payment_id = c.payment_id');
 $this->db->where('a.paid_amount = a.gtotal');
        $this->db->where('a.user_emp_id', $templ_name);
    $this->db->where('a.sales_by', $this->session->userdata('user_id'));
    $this->db->where('c.payment_date >=', $formattedStartDate);
    $this->db->where('c.payment_date <=', $formattedendDate);
    $this->db->group_start(); // Start a group of OR conditions
$this->db->where('c.balance', '0.00');
$this->db->or_where('c.balance', '0.0');
$this->db->or_where('c.balance', '0');
$this->db->group_end(); // End the group of OR conditions
    // Subquery to get the last inserted row based on payment_id
    // $subQuery = "(SELECT * FROM payment ORDER BY payment_date DESC LIMIT 1) as d";
    // $this->db->join($subQuery, 'a.payment_id = d.payment_id');
$query = $this->db->get();
$result['sc'] = $query->result_array();
// Process the result to remove duplicates
// Create a temporary array to store unique commercial_invoice_number
$tempArray = [];
$filteredResult = [];
foreach ($result['sc'] as $row) {
    $invoiceNumber = $row['commercial_invoice_number'];
    if (!in_array($invoiceNumber, $tempArray)) {
        $tempArray[] = $invoiceNumber;
        $filteredResult[] = $row;
    }
}
$result['sc'] = $filteredResult;
$count = count($filteredResult);  
$result['count'] = $count;
 $total_gtotal = 0;
foreach ($filteredResult as $row) {
    $total_gtotal += $row['gtotal'];
}
$result['total_gtotal'] = $total_gtotal;
 foreach ($filteredResult as &$row) {
    $row['sc'] *= $count;
}
return $result;
}
    public function employee_info($templ_name){
        $this->db->select('*');
        $this->db->from('employee_history');
        $this->db->where('id', $templ_name);
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
        return true;
    }
    public function timesheet_info_data($timesheet_id){
        $this->db->select('*');
        $this->db->from('timesheet_info');
        $this->db->where('timesheet_id', $timesheet_id);
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
        return true;
    }
    public function delete_off_loan($transaction_id){
        $this->db->where('transaction_id', $transaction_id);
        $this->db->delete('person_ledger');
        return true;
      }
      public function get_data_payslip(){
          $this->db->select('a.*,b.*,c.*');
          $this->db->from('timesheet_info a');
          $this->db->join('employee_history b' , 'a.templ_name = b.id');
          $this->db->join('tax_history c' , 'c.time_sheet_id  = a.timesheet_id');
           $this->db->group_by('c.time_sheet_id'); 
          $this->db->where('a.uneditable', '1');
          $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if($_SESSION['u_type'] ==3){
          $this->db->where('a.unique_id',$this->session->userdata('unique_id'));
          }
          $this->db->order_by('a.id', 'asc');  
          $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
          }
          return true;
    }
    public function office_loan_datas($transaction_id){
        $this->db->select('*');
        $this->db->from('person_ledger');
        $this->db->where('transaction_id', $transaction_id);
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
  public function timesheet_list(){
         $this->db->select('*');
         $this->db->from('timesheet_info a');
         $this->db->join('employee_history b' , 'a.templ_name = b.id');
         $this->db->where('a.create_by',$this->session->userdata('user_id'));
          if($_SESSION['u_type'] ==3){
          $this->db->where('a.unique_id',$this->session->userdata('unique_id'));
          }
         $this->db->order_by('a.id', 'asc');  
         $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
    // Update Expense
    public function update_expense_id($id)
    {
        $data = array(
            'emp_name'  => $this->input->post('person_id',TRUE),
            'expense_name' => $this->input->post('expense_name',TRUE),
            'expense_date' => $this->input->post('expense_date',TRUE),
            'expense_amount' => $this->input->post('expense_amount',TRUE),
            'total_amount' => $this->input->post('total_amount',TRUE),
            'expense_payment_date' => $this->input->post('expense_payment_date',TRUE),
             'status' => $this->input->post('status',TRUE),
            'description' => $this->input->post('description',TRUE),
            'unique_id'  =>$this->input->post('unique_id',TRUE),
        );
        $this->db->where('id', $id);
        $this->db->update('expense', $data);
         return true;
    }
public function expense_list(){
      $this->db->select('*');
        $this->db->from('expense');
        $this->db ->where('create_by',$this->session->userdata('user_id'));
         if($_SESSION['u_type'] ==3){
              $this->db ->where('unique_id',$this->session->userdata('unique_id'));
         }
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
}
    //Get expense by id
    public function get_expense_by_id($id) {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('id', $id);
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function administrator_info($ads_id){
        $this->db->select('*');
        $this->db->from('administrator');
        $this->db->where('adm_id',$ads_id);
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
        return true;
    }
    // Pdf Download Expense
    public function pdf_expense($id)
    {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('id', $id);
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
 public function tax_info($id){
    $this->db->select('*');
    $this->db->from('info_payslip');
    $this->db->where('timesheet_id' , $id);
  $query = $this->db->get(); 
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
  }
  public function time_sheet_data($id){
    $this->db->select('*');
    $this->db->from('timesheet_info a');
        $this->db->join('timesheet_info_details b' , 'a.timesheet_id = b.timesheet_id');
   $this->db->where('a.timesheet_id' , $id);
  $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
  }
    public function administrator_data(){
        $this->db->select('*');
        $this->db->from('administrator');
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
    public function employee_name1() {
        $this->db->select('*');
        $this->db->from('employee_history');
          $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result_array();
    }
        return false;
    }
public function employee_partner($id) {
 $this->db->select('a.*,a.id as emp_id');
        $this->db->from('employee_history a');
        $this->db->where('a.id', $id);
             $this->db->where('a.create_by',$this->session->userdata('user_id'));
            $query = $this->db->get();
       if ($query->num_rows() > 0) {
        return $query->result_array();
    }
        return false;
    }
public function employee_name($id) {
 $this->db->select('a.*,a.id as emp_id,b.designation');
        $this->db->from('employee_history a');
        $this->db->where('a.id', $id);
           $this->db->join('designation  b', 'b.designation =a.designation');
             $this->db->where('a.create_by',$this->session->userdata('user_id'));
            $query = $this->db->get();
       if ($query->num_rows() > 0) {
        return $query->result_array();
    }
        return false;
    }
    public function employeeinfo() {
        $this->db->select('*');
        $this->db->from('timesheet_info');
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result_array();
    }
        return false;
    }
    public function insert_adsrs_data($data) {
      $this->db->insert('administrator', $data);
        $this->db->select('*');
        $this->db->from('administrator');
         $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_payment_terms(){
        $this->db->select('*');
        $this->db->from('payment_terms');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
          return $query->result_array();
    }
    public function insert_duration_data($postData){
        $data=array(
            'duration_name' => $postData,
            'create_by' => $this->session->userdata('user_id')
        );
         $this->db->insert('duration', $data);
         $this->db->select('*');
        $this->db->from('duration');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_dailybreak(){
        $this->db->select('*');
        $this->db->from('dailybreak');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_duration_data(){
        $this->db->select('*');
        $this->db->from('duration');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
 public function getemp_data($value){
        $this->db->select('a.*,b.*');
        $this->db->from('employee_history a');
        $this->db->where('a.id', $value);
           $this->db->join('designation  b', 'b.designation =a.designation');
            $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $query = $this->db->get()->result();
         return $query;
    }
    public function insert_dailybreak_data($postData){
        $data=array(
            'dailybreak_name' => $postData,
            'create_by' => $this->session->userdata('user_id')
        );
         $this->db->insert('dailybreak', $data);
         $this->db->select('*');
        $this->db->from('dailybreak');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
public function timesheet_data($id) {
    $this->db->select('*');
    $this->db->from('employee_history');
    $this->db->where('id', $id);
    $query = $this->db->get();
       if ($query->num_rows() > 0) {
          return $query->result_array();
      }
}
    public function count_designation() {
        return $this->db->count_all("designation");
    }
public function create_designation($data = []){
$data['create_by']=$this->session->userdata('user_id');
return $this->db->insert('designation',$data);
}
public function designation_info($postData){
        $data=array(
            'designation' => $postData,
            'create_by' => $this->session->userdata('user_id')
        );
        $this->db->insert('designation', $data);
         $this->db->select('*');
        $this->db->from('designation');
        $this->db->where('create_by' ,$this->session->userdata('user_id'));
         $query = $this->db->get();
        return $query->result_array();
    }
public function city_tax(){
    $this->db->select('city_tax');
           $this->db->from('city_tax');
           $this->db->where('created_by',$this->session->userdata('user_id'));
          $query = $this->db->get();
           if ($query->num_rows() > 0) {
              return $query->result_array();
           }
            return true;
   }
public function paytype_dropdown(){
        $this->db->select('payment_type');
        $this->db->from('payment_type');
       $this->db->where('create_by', $this->session->userdata('user_id'));
         $this->db->order_by('payment_type','asc');
       $query = $this->db->get();
         if ($query->num_rows() > 0) {
             return $query->result_array();
         }
        }
           public function city_tax_dropdown(){
            $this->db->select('city_tax');
            $this->db->from('city_tax');
           $this->db->where('created_by', $this->session->userdata('user_id'));
             $this->db->order_by('city_tax','asc');
           $query = $this->db->get();
             if ($query->num_rows() > 0) {
                 return $query->result_array();
             }
            }
public function designation_dropdown(){
        $this->db->select('*');
        $this->db->from('designation');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    //designation List
    public function designation_list() {
        $this->db->select('*');
        $this->db->from('designation');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Retrieve designation Edit Data
    public function designation_editdata($id) {
        $this->db->select('*');
        $this->db->from('designation');
        $this->db->where('create_by',$this->session->userdata('user_id'));
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Update Categories
    public function update_designation($data = []) {
        $this->db->where('id', $data['id']);
        $this->db->update('designation', $data);
        return true;
    }
    // Delete designation Item
    public function delete_designation($id) {
        $this->db->where('id', $id);
        $this->db->delete('designation');
        return true;
    }
    // create employee
   public function create_employee($data = []){
     $this->db->insert('employee_history',$data);
      $id =$this->db->insert_id();
     $coa = $this->headcode();
           if($coa->HeadCode!=NULL){
                $headcode=$coa->HeadCode+1;
           }else{
                $headcode="502040001";
            }
    $c_acc=$id.'-'.$data['first_name'].''.$data['last_name'];
  $createby=$this->session->userdata('user_id');
  $createdate=date('Y-m-d H:i:s');
    $employee_coa = [
             'HeadCode'         => $headcode,
             'HeadName'         => $c_acc,
             'PHeadName'        => 'Employee Ledger',
             'HeadLevel'        => '3',
             'IsActive'         => '1',
             'IsTransaction'    => '1',
             'IsGL'             => '0',
             'HeadType'         => 'L',
             'IsBudget'         => '0',
             'IsDepreciation'   => '0',
             'DepreciationRate' => '0',
             'CreateBy'         => $createby,
             'CreateDate'       => $createdate,
        ];
        $this->db->insert('acc_coa',$employee_coa);
        return true;
   }
public function delete_tax($tax = null, $state) {
    $this->db->where('tax', $state . '-' . $tax);
    $this->db->where('create_by', $this->session->userdata('user_id'));
    $this->db->where('Type', 'State');  
    $this->db->delete('state_and_tax');
     if ($tax) {
        $sql = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ?, ''), ',', ',') WHERE created_by=? AND state=? AND Type='State'";
        $query = $this->db->query($sql, array($tax, $this->session->userdata('user_id'), $state));
    } else {
        $this->db->where('state', $state);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $this->db->where('Type', 'State');  
        $this->db->delete('state_and_tax');
    }
    $sql1 = "UPDATE state_and_tax SET tax = TRIM(BOTH ',' FROM tax) WHERE Type='State'";
    $query1 = $this->db->query($sql1);
    $sql3 = "UPDATE state_and_tax SET tax = REPLACE(REPLACE(tax, ',,', ','), ',', ',') WHERE created_by=? AND state=? AND Type='State'";
    $query3 = $this->db->query($sql3, array($this->session->userdata('user_id'), $state));
    return true;
}
   public function employee_list(){
$this->db->select('*');
     $this->db->from('employee_history');
     $this->db->where('create_by',$this->session->userdata('user_id'));
     $query = $this->db->get();
     if ($query->num_rows() > 0) {
       return $query->result_array();
     }
     return false;
}
   // Employee Edit data
   public function employee_editdata($id){
        $this->db->select('*');
        $this->db->from('employee_history');
        $this->db->where('id', $id);
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
   }
public function payroll_editdata($id){
        $this->db->select('*');
        $this->db->from('payroll_type');
        $this->db->where('id', $id);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function employeestype_editdata($id){
        $this->db->select('*');
        $this->db->from('employee_type');
        $this->db->where('id', $id);
        $this->db->where('created_by', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
     public function headcode(){
        $query=$this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='3' And HeadCode LIKE '50204000%'");
        return $query->row();
    }
// update employee
    public function update_employee($data = [],$headname,$emp_data,$pay_data){
        $this->db->where('id', $data['id']);
        $this->db->update('employee_history',$data);
        $this->db->where('id', $emp_data['id']);
        $this->db->update('employee_type',$emp_data);
        $this->db->where('id', $pay_data['id']);
        $this->db->update('payroll_type',$pay_data);
     $id = $data['id'];
    $up_headname = $id.'-'.$data['first_name'].''.$data['last_name'];
    $updatedby   = $this->session->userdata('user_id');
    $updateddate = date('Y-m-d H:i:s');
    $employee_coa = [
             'HeadName'         => $up_headname,
             'UpdateBy'         => $updatedby,
             'UpdateDate'       => $updateddate,
        ];
        $this->db->where('HeadName', $headname);
        $this->db->update('acc_coa',$employee_coa);
        return true;
    }
public function getTaxdetailsdata($tax){
        $this->db->select('*');
        $this->db->from('state_localtax');
        $this->db->where('tax', $tax);
         $this->db->where('create_by',$this->session->userdata('user_id'));
         $query = $this->db->get();
          if ($query->num_rows() > 0) {
           return $query->result_array();
         }
         return false;
    }
       public function delete_employee($id) {
        $this->db->where('id', $id);
        $this->db->delete('employee_history');
        $this->db->where('id', $id);
        $this->db->delete('payroll_type');
        $this->db->where('id', $id);
        $this->db->delete('employee_type');
        return true;
    }
      public function employee_detl($id){
        $this->db->select('*');
        $this->db->from('employee_history a');
         $this->db->join('designation b','a.designation = b.id');
        $this->db->where('a.id', $id);
           $this->db->where('a.create_by',$this->session->userdata('user_id'));
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
   }
      public function employee_details($id){
        $this->db->select('*');
        $this->db->from('employee_history ');
         $this->db->where('id', $id);
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
   }
   public function get_customersData()
   {
        $this->db->select('*');
        $this->db->from('employee_history ');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
   }
   public function get_employer_federaltax()
   {
       $user_id = $this->session->userdata('user_id');
       $this->db->select('*');
       $this->db->from('user_login');
       $this->db->where('user_id', $user_id);
       $this->db->where('u_type', '2');
       $this->db->where('security_code IS NOT NULL');
       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
      public function get_payslip_info()
   {
       $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(total_amount) as overalltotal_amount ,SUM(f_tax) as  ftotal_amount ,SUM(s_tax) as  stotal_amount , SUM(m_tax) as  mtotal_amount , sales_c_amount');
       $this->db->from('info_payslip');
       $this->db->where('create_by', $user_id);
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
     public function get_sc_info()
      {
          $user_id = $this->session->userdata('user_id');
          $this->db->select('SUM(a.sc) AS salebalanceamount');       
          $this->db->from('info_payslip a');
          $this->db->join('employee_history b', 'b.id = a.templ_name');
          $this->db->where('b.choice', 'No');
          $this->db->where('a.create_by', $user_id);
          $query = $this->db->get();
           if ($query !== false && $query->num_rows() > 0) {
              return $query->result_array();
          } 
          return false;
      }
      public function get_941_sc_info($selectedValue)
      {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(a.sc) AS salebalanceamount');       
        $this->db->distinct();  
        $this->db->from('info_payslip a');
        $this->db->join('employee_history b', 'b.id = a.templ_name');
        $this->db->join('timesheet_info c', 'c.templ_name = a.templ_name');
        $this->db->where('b.choice', 'No');
        $this->db->where('a.create_by', $user_id);
        $this->db->where('c.quarter', $selectedValue);
        $this->db->group_by('c.timesheet_id');  
        $query = $this->db->get();
         if ($query !== false && $query->num_rows() > 0) {
            return $query->result_array();
        } 
        return false;
      }
   public function get_company_info()
   {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            return false;
       }
       try {
           $this->db->select('*');
           $this->db->from('company_information');
           $this->db->where('company_id', $user_id);
            $query = $this->db->get();
            if ($query === false) {
                return false;
           }
           if ($query->num_rows() > 0) {
                return $query->result_array();
           }
            return false;
       } catch (Exception $e) {
           log_message('error', 'Error in get_company_info: ' . $e->getMessage());
           return false;
       }
   }
      public function total_state_tax()
   {
       $user_id = $this->session->userdata('user_id');
       $this->db->select('SUM(amount) as overalltotal_statetax');       
       $this->db->from('tax_history');
       $this->db->where('created_by', $user_id);
        $this->db->where_in('tax_type', ['state_tax' , 'living_state_tax']);
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
 public function total_local_tax()
   {
       $user_id = $this->session->userdata('user_id');
       $this->db->select('SUM(amount) as overalltotal_localtax');
       $this->db->from('tax_history');
       $this->db->where('created_by', $user_id);
       $this->db->where_in('tax_type', ['local_tax' , 'living_local_tax' , 'living_state_tax']);
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
   public function employeeDetailsdata($id = null)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('employee_history');
    $this->db->where('id', $id);
    $this->db->where('create_by', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
   }
}
  public function employeerDetailsdata()
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('company_information');
    $this->db->where('company_id', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
   }
} 
public function get_total_customersData() {
    $user_id = $this->session->userdata('user_id');
    $this->db->select('COUNT(DISTINCT templ_name) AS employee_count');
    $this->db->from('info_payslip');
    $this->db->where('info_payslip.create_by', $user_id);
    $query = $this->db->get();
        if ($query) {
        return $query->result_array();
    } else {
         log_message('error', 'Database error in get_total_customersData: ' . $this->db->_error_message());
        return 0;  
    }
}
       public function count_payslip()
   {
    $user_id = $this->session->userdata('user_id');
       $this->db->select('COUNT(timesheet_info.timesheet_id) as totalts');
       $this->db->from('timesheet_info');
       $this->db->where('timesheet_info.create_by', $user_id);
       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
  public function get_taxinfomation_old()
  {
    $user_id = $this->session->userdata('user_id');
$this->db->select('ti.timesheet_id');
$this->db->select('SUM(ip.s_tax) AS sum_s_tax');
$this->db->select('SUM(ip.f_tax) AS sum_f_tax');
$this->db->select('SUM(ip.u_tax) AS sum_u_tax');
$this->db->select('SUM(ip.m_tax) AS sum_m_tax');
$this->db->select('SUM(ip.total_amount) AS sum_total_amount');
$this->db->from('timesheet_info ti');
$this->db->join('info_payslip ip', 'ti.timesheet_id = ip.timesheet_id', 'inner');
$this->db->where('ti.create_by', $user_id);
$this->db->group_by('ti.timesheet_id');
  $query = $this->db->get();
     if ($query->num_rows() > 0) {
          return $query->result_array();
      }
      return false;
  }
public function get_taxinfomation($selectedValue)
{
$user_id = $this->session->userdata('user_id');
$this->db->select('ti.timesheet_id');
$this->db->select('SUM(ip.s_tax) AS sum_s_tax');
$this->db->select('SUM(ip.f_tax) AS sum_f_tax');
$this->db->select('SUM(ip.u_tax) AS sum_u_tax');
$this->db->select('SUM(ip.m_tax) AS sum_m_tax');
$this->db->select('SUM(ip.total_amount) AS sum_total_amount');
$this->db->from('timesheet_info ti');
$this->db->join('info_payslip ip', 'ti.timesheet_id = ip.timesheet_id', 'inner');
$this->db->where('ti.create_by', $user_id);
$this->db->where('ti.quarter', $selectedValue);
$this->db->where('ti.uneditable', '1');
$this->db->group_by('ti.timesheet_id');
$query = $this->db->get();
  if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
        public function getoveralltaxdata($id)
    {
        $user_id = $this->session->userdata('user_id');
        $currentYear = date('Y');
        $this->db->select('a.*, b.*, c.*,b.f_tax as f_ftax,b.m_tax as m_mtax,b.s_tax as s_stax,b.u_tax as u_utax,a.timesheet_id as timesheet,d.s_tax as stax,d.m_tax as mtax,d.f_tax as ftax,d.u_tax as utax, d.tax_type, d.tax');
        $this->db->from('timesheet_info a');
        $this->db->join('info_payslip b', 'b.templ_name = a.templ_name');
        $this->db->join('employee_history c', 'c.id = b.templ_name');
        $this->db->join('tax_history_employer d', 'd.time_sheet_id = a.timesheet_id','left');
        $this->db->where('a.create_by', $user_id);
        $this->db->where("a.start LIKE '%$currentYear'");
         $this->db->where('c.id', $id);
        $this->db->group_by('a.timesheet_id');
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function w2total_state_tax($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('ROUND(SUM(amount), 2) as overalltotal_statetax0  ,ROUND(SUM(weekly), 2) as overalltotal_statetax1  , ROUND(SUM(biweekly), 2) as overalltotal_statetax2  ,  ROUND(SUM(monthly), 2) as overalltotal_statetax3 ');
        $this->db->from('tax_history');
        $this->db->where('created_by', $user_id);
        $this->db->where('employee_id', $id);
        $this->db->where_in('tax', ['Income tax' ]);   
        $this->db->where_in('tax_type', ['state_tax' ]);   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // w2 state tax Working Tax
    public function w2totalstatetaxworking($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('ROUND(SUM(amount), 2) as overalltotal_statetaxworking');
        $this->db->from('tax_history');
        $this->db->where('created_by', $user_id);
        $this->db->where('employee_id', $id);
        $this->db->where_in('tax_type', ['living_state_tax']); 
        $this->db->where("tax LIKE '%Income tax%'");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
      public function sum_of_hourly()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.amount) as amount');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where('tax_history.weekly IS NULL', null, false);
        $this->db->where('tax_history.biweekly IS NULL', null, false);
        $this->db->where('tax_history.monthly IS NULL', null, false);
       $this->db->where("tax_history.tax LIKE '%Income tax%'");
       $this->db->where('tax_history.tax_type', 'state_tax');
       $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function sum_of_weekly()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.weekly) as weekly');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where('tax_history.biweekly IS NULL', null, false);
        $this->db->where('tax_history.monthly IS NULL', null, false);
        $this->db->where("tax_history.tax LIKE '%Income tax%'");
        $this->db->where("tax_history.tax_type LIKE '%state_tax%'");
        $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function sum_of_biweekly()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.biweekly) as biweekly');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where('tax_history.weekly IS NULL', null, false);
        $this->db->where('tax_history.monthly IS NULL', null, false);
      $this->db->where("tax_history.tax LIKE '%Income tax%'");
        $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function sum_of_monthly()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.monthly) as monthly');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where('tax_history.weekly IS NULL', null, false);
        $this->db->where('tax_history.biweekly IS NULL', null, false);
      $this->db->where("tax_history.tax LIKE '%Income tax%'");
        $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
        public function sum_of_livingstatetax(){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.amount) as totalamount');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where("tax_history.tax_type", "living_state_tax");
        $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function sum_of_workingstatetax(){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(tax_history.amount) as totalamount');
        $this->db->from('tax_history');
        $this->db->where('tax_history.created_by', $user_id);
        $this->db->where("tax_history.tax_type", "state_tax");
        $this->db->join('employee_history', 'employee_history.id = tax_history.employee_id', 'inner');
        $this->db->where('(employee_history.sales_partner IS NULL OR employee_history.sales_partner = "")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
//w2 living state tax 564.80
    public function w2total_local_tax($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('code, ROUND(SUM(amount), 2) as overalltotal_localtax');
        $this->db->from('tax_history');
        $this->db->where('created_by', $user_id);
        $this->db->where('employee_id', $id);
        $this->db->where_in('tax_type', ['local_tax']);
        $this->db->group_by('code'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
// w2 living local tax
public function w2total_livinglocaldata($id)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('ROUND(SUM(amount), 2) as livinglocaltax');
    $this->db->from('tax_history');
    $this->db->where('created_by', $user_id);
    $this->db->where('employee_id', $id);
    $this->db->where_in('tax_type', ['living_local_tax']);
    $this->db->group_by('code, tax_type'); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function tax_statecode_info($id)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('code, tax_type');
    $this->db->from('tax_history');
    $this->db->where('created_by', $user_id);
    $this->db->where('employee_id', $id);
     $this->db->group_by('code, tax_type'); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
    public function w2total_statedata($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('tax_history');
        $this->db->where('created_by', $user_id);
        $this->db->where('employee_id', $id);
        $this->db->where_in('tax_type', ['living_state_tax', 'state_tax']);
        $this->db->group_by('code, tax_type'); 
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function gettaxother_info($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('code,tax, SUM(amount) as amount'); 
        $this->db->from('tax_history');
        $this->db->where('created_by', $user_id);
        $this->db->where('employee_id', $id);
        $this->db->where("(tax_type = 'state_tax' OR tax_type = 'living_state_tax' OR tax_type = 'other_tax' OR tax_type = 'other_working_tax')");
        $this->db->where("tax NOT LIKE '%Income Tax%'");
        $this->db->group_by('code,tax');  
        $this->db->order_by('tax');  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
public function getother_tax($id)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('code,tax, SUM(amount) AS amount'); // Summing the amounts for each tax
    $this->db->from('tax_history');
    $this->db->where('created_by', $user_id);
    $this->db->where('employee_id', $id);
    $this->db->where("(tax_type = 'other_tax' OR tax_type = 'other_working_tax')");
    $this->db->group_by('code,tax');  
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function getcounty_tax($id)
{
    $user_id = $this->session->userdata('user_id');
     $this->db->select('code,tax, SUM(amount) AS amount');
    $this->db->from('tax_history');
    $this->db->where('created_by', $user_id);
    $this->db->where('employee_id', $id);
    $this->db->where("(tax_type = 'living_county_tax' OR tax_type = 'working_county_tax')");
    $this->db->group_by('code,tax'); 
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function w2get_payslip_info($id)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('SUM(total_amount) as overalltotal_amount ,SUM(f_tax) as  ftotal_amount ,SUM(s_tax) as  stotal_amount , SUM(m_tax) as  mtotal_amount');       
    $this->db->from('info_payslip');
    $this->db->where('templ_name', $id);
    $this->db->where('create_by', $user_id);
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
public function w2get_payslip_alldata($id)
{
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');       
    $this->db->from('info_payslip');
    $this->db->where('templ_name', $id);
    $this->db->where('create_by', $user_id);
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return false;
}
    public function get_paytotal()
   {
       $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(total_amount) as total_grosspay');
        $this->db->from('info_payslip');
        $this->db->where('create_by', $user_id);
        $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result_array();
       }
       return false;
   }
public function timesheet_data_emp()
{
     $user_id = $this->session->userdata('user_id');
     $this->db->select('*');
    $this->db->from('timesheet_info a');  
    $this->db->join('employee_history b', 'b.id = a.templ_name', 'left');  
    $this->db->where('a.create_by', $user_id);  
  $this->db->where('(b.sales_partner IS NULL OR b.sales_partner = "")');
     $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
}
public function hourly_tax_info($employee_status,$final,$hourly_range){
    $this->db->select('employee,employer,details');
    $this->db->from('state_localtax');
    $this->db->where($employee_status,$hourly_range);
   $query = $this->db->get();
    if ($query->num_rows() > 0) {
       return $query->result_array();
    }
     return true;
}
public function get_taxname_weekly(){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('weekly_tax_info');
    $this->db->where('create_by', $user_id); 
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
     }
      return true;
}
public function get_taxname_biweekly(){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('biweekly_tax_info');
    $this->db->where('create_by', $user_id);  
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
     }
      return true;
}
public function get_taxname_monthly(){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('monthly_tax_info');
    $this->db->where('create_by', $user_id);  
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
     }
      return true;
}
    public function weekly_tax_info($employee_status,$final,$weekly_range){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('employee,employer,details');
        $this->db->from('weekly_tax_info');
        $this->db->where($employee_status,$weekly_range);
        $this->db->where('create_by', $user_id);  
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
        }
         return true;
}
public function biweekly_tax_info($employee_status,$final,$biweekly_range){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('employee,employer,details');
    $this->db->from('biweekly_tax_info');
    $this->db->where($employee_status,$biweekly_range);
    $this->db->where('create_by', $user_id);  
   $query = $this->db->get();
    if ($query->num_rows() > 0) {
       return $query->result_array();
    }
     return true;
}

// Generate Payslip - Yokesh
public function getPaginatedpayslip($limit, $offset, $orderField, $orderDirection, $search, $date = null, $emp_name = 'All')
    {
        $this->db->select('a.*,b.*,c.*');
        if ($date) {
            $dates = explode(' to ', $date);
            $start_date = $dates[0];
            $end_date = $dates[1];
            $this->db->where('a.cheque_date >=', $start_date);
            $this->db->where('a.cheque_date <=', $end_date);
            $this->db->where("a.cheque_date BETWEEN '$start_date' AND '$end_date'");
        }
        if ($emp_name !== 'All') {
            $trimmed_emp_name = trim($emp_name);
            $this->db->group_start();
            $this->db->like("TRIM(CONCAT_WS(' ', b.first_name, b.middle_name, b.last_name))", $trimmed_emp_name);
            $this->db->or_like("TRIM(CONCAT_WS(' ', b.first_name, b.last_name))", $trimmed_emp_name);
            $this->db->group_end();
        }
        $this->db->from('timesheet_info a');
        $this->db->join('employee_history b' , 'a.templ_name = b.id');
        $this->db->join('tax_history c' , 'c.time_sheet_id  = a.timesheet_id');
         $this->db->group_by('c.time_sheet_id');
         if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("a.timesheet_id", $search);
            $this->db->or_like("b.first_name", $search);
            $this->db->or_like("b.last_name", $search);
            $this->db->or_like("b.middle_name", $search);
            $this->db->or_like("b.employee_tax", $search);
            $this->db->group_end();
        }
        $this->db->where('a.uneditable', '1');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if($_SESSION['u_type'] ==3){
            $this->db->where('a.unique_id',$this->session->userdata('unique_id'));
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderField, $orderDirection);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        if ($query === false) {
            return false;
        }
        return $query->result_array();
    }
    // Total Payslip -Yokesh
    public function getTotalpayslip($search, $date, $emp_name = 'All')
    {
        $this->db->select('a.*,b.*,c.*');
        if ($date) {
            $dates = explode(' to ', $date);
            $start_date = $dates[0];
            $end_date = $dates[1];
            $this->db->where('a.cheque_date >=', $start_date);
            $this->db->where('a.cheque_date <=', $end_date);
            $this->db->where("a.cheque_date BETWEEN '$start_date' AND '$end_date'");
        }
        if ($emp_name !== 'All') {
            $trimmed_emp_name = trim($emp_name);
            $this->db->group_start();
            $this->db->like("TRIM(CONCAT_WS(' ', b.first_name, b.middle_name, b.last_name))", $trimmed_emp_name);
            $this->db->or_like("TRIM(CONCAT_WS(' ', b.first_name, b.last_name))", $trimmed_emp_name);
            $this->db->group_end();
        }
        $this->db->from('timesheet_info a');
        $this->db->join('employee_history b' , 'a.templ_name = b.id');
        $this->db->join('tax_history c' , 'c.time_sheet_id  = a.timesheet_id');
         $this->db->group_by('c.time_sheet_id');
         if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("a.timesheet_id", $search);
            $this->db->or_like("b.first_name", $search);
            $this->db->or_like("b.last_name", $search);
            $this->db->or_like("b.middle_name", $search);
            $this->db->or_like("b.employee_tax", $search);
            $this->db->group_end();
        }
        $this->db->where('a.uneditable', '1');
        $this->db->where('a.create_by',$this->session->userdata('user_id'));
        if($_SESSION['u_type'] ==3) {
            $this->db->where('a.unique_id',$this->session->userdata('unique_id'));
        }
        $query = $this->db->get();
        if ($query === false) {
            return false;
        }
        return $query->num_rows();
    }
public function monthly_tax_info($employee_status,$final,$monthly_range){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('employee,employer,details');
    $this->db->from('monthly_tax_info');
    $this->db->where($employee_status,$monthly_range);
    $this->db->where('create_by', $user_id); 
   $query = $this->db->get();
    if ($query->num_rows() > 0) { 
       return $query->result_array();
    }
     return true;
}
public function info_for_nj($quarter)
{
     $user_id = $this->session->userdata('user_id');
     $this->db->select('*');
     $this->db->from('timesheet_info a'); 
     $this->db->join('employee_history b', 'b.id = a.templ_name', 'left'); 
     $this->db->join('info_payslip c', 'c.timesheet_id = a.timesheet_id', 'left'); 
     $this->db->where("b.payroll_type NOT LIKE 'Sales Partner'");
     $this->db->where('a.quarter',$quarter); 
     $this->db->where('a.create_by', $user_id); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
}
public function total_amountofthis_qt($quarter)
{
     $user_id = $this->session->userdata('user_id');
     $this->db->select('SUM(c.total_amount) as OverallTotal');
     $this->db->from('timesheet_info a'); 
     $this->db->join('employee_history b', 'b.id = a.templ_name', 'left'); 
     $this->db->join('info_payslip c', 'c.timesheet_id = a.timesheet_id', 'left'); 
     $this->db->where("b.payroll_type NOT LIKE 'Sales Partner'");
     $this->db->where('a.quarter',$quarter); 
     $this->db->where('a.create_by', $user_id); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return false;
    }
}
public function get_data_salespartner_another()
{
$user_id = $this->session->userdata('user_id');
$this->db->select('*');
$this->db->from('timesheet_info a');  
$this->db->join('employee_history b', 'b.id = a.templ_name', 'left'); 
$this->db->where('b.sales_partner','Sales_Partner');  
$this->db->where('a.create_by', $user_id);  
$query = $this->db->get();
if ($query->num_rows() > 0) {
    return $query->result_array();
} else {
    return [];
}
}
  public function get_taxname_living_hourly($lst_name){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('state_localtax');
    $this->db->where('create_by', $user_id); 
    $this->db->like('tax', $lst_name, 'after'); 
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
     }
    return true;
}
public function get_taxname_living_weekly($lst_name){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('weekly_tax_info');
    $this->db->where('create_by', $user_id); 
    $this->db->like('tax', 'Weekly '.$lst_name, 'after'); 
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result_array();
     }
    return true;
}
public function get_taxname_living_biweekly($lst_name){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('biweekly_tax_info');
    $this->db->where('create_by', $user_id); 
    $this->db->like('tax', 'BIWeekly '.$lst_name, 'after'); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
     }
    return true;
}
public function get_taxname_living_monthly($lst_name){
    $user_id = $this->session->userdata('user_id');
    $this->db->select('tax');
    $this->db->from('monthly_tax_info');
    $this->db->where('create_by', $user_id); 
    $this->db->like('tax', 'Monthly '.$lst_name, 'after'); 
    $query = $this->db->get();
     if ($query->num_rows() > 0) {
        return $query->result_array();
     }
    return true;
}
    public function get_employee_sal($id){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('h_rate,total_hours,extra_thisrate, SUM(extra_thisrate) as totalamout');
        $this->db->from('timesheet_info');
        $this->db->where('templ_name', $id); 
        $this->db->where('create_by', $user_id); 
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
         }
        return true;
    }
    public function total_unemployment($id){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(unemployement_total) as unempltotal');
        $this->db->from('tax_history_employer');
        $this->db->where('employee_id', $id); 
        // $this->db->where('tax', 'Unemployment'); 
        $this->db->where('created_by', $user_id); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
         }
        return true;
    }
 
     public function get_employee_sal_ytd($id){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('SUM(total_amount) as overalltotal');
        $this->db->from('info_payslip');
        $this->db->where('templ_name', $id); 
        $this->db->where_in('tax', ['Income tax', 'Unemployment']);
        $this->db->where('create_by', $user_id); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
         }
        return true;
    }


    // Paginated Federal income tax
    public function getPaginatedfederalincometax($limit, $offset, $orderField, $orderDirection, $search, $date = null, $emp_name = 'All')
    {
        $user_id = $this->session->userdata("user_id");

        $subquery = "(SELECT DISTINCT b.timesheet_id FROM info_payslip b JOIN timesheet_info a ON a.timesheet_id = b.timesheet_id WHERE b.create_by = '$user_id'";
        
        if ($date) {
            $dates = explode(' to ', $date);
            $start_date = $dates[0];
            $end_date = $dates[1];  
            $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
        }

        if ($emp_name !== 'All') {
            $trimmed_emp_name = trim($emp_name);
            $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
        }
        
        $subquery .= ")";

        $this->db->select('a.month, b.timesheet_id as timesheet, c.employee_tax, b.templ_name, a.cheque_date, c.first_name, c.middle_name, c.last_name, b.f_tax AS f_tax, b.m_tax AS m_tax, b.s_tax AS s_tax, b.u_tax AS u_tax');
        
        $this->db->from('info_payslip b');
        $this->db->join('employee_history c', 'c.id = b.templ_name');
        $this->db->join('timesheet_info a', 'a.timesheet_id = b.timesheet_id');
        $this->db->where("b.timesheet_id IN $subquery", NULL, FALSE);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("b.timesheet_id", $search);
            $this->db->or_like("c.first_name", $search);
            $this->db->or_like("c.last_name", $search);
            $this->db->or_like("c.middle_name", $search);
            $this->db->or_like("c.employee_tax", $search);
            $this->db->group_end();
        }
        
        $this->db->where("b.create_by", $user_id);

        $this->db->limit($limit, $offset);
        $this->db->order_by($orderField, $orderDirection);
        
        $query = $this->db->get();

        // echo $this->db->last_query(); die();

        if ($query === false) {
            return false;
        }

        return $query->result_array();
    }
    
    // Total Income Tax 
    public function getTotalfederalincometax($search, $date, $emp_name = 'All')
    {
        $user_id = $this->session->userdata("user_id");

        $subquery = "(SELECT DISTINCT b.timesheet_id FROM info_payslip b JOIN timesheet_info a ON a.timesheet_id = b.timesheet_id WHERE b.create_by = '$user_id'";
        
        if ($date) {
            $dates = explode(' to ', $date);
            $start_date = date('Y-m-d', strtotime($dates[0]));
            $end_date = date('Y-m-d', strtotime($dates[1]));  
            $subquery .= " AND (a.cheque_date BETWEEN '$start_date' AND '$end_date')";
        }

        if ($emp_name !== 'All') {
            $trimmed_emp_name = trim($emp_name);
            $subquery .= " AND (TRIM(CONCAT_WS(' ', c.first_name, c.middle_name, c.last_name)) LIKE '%$trimmed_emp_name%' OR TRIM(CONCAT_WS(' ', c.first_name, c.last_name)) LIKE '%$trimmed_emp_name%')";
        }
        
        $subquery .= ")";

        $this->db->select('a.month');
        
        $this->db->from('info_payslip b');
        $this->db->join('employee_history c', 'c.id = b.templ_name');
        $this->db->join('timesheet_info a', 'a.timesheet_id = b.timesheet_id');
        $this->db->where("b.timesheet_id IN $subquery", NULL, FALSE);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("b.timesheet_id", $search);
            $this->db->or_like("c.first_name", $search);
            $this->db->or_like("c.last_name", $search);
            $this->db->or_like("c.middle_name", $search);
            $this->db->or_like("c.employee_tax", $search);
            $this->db->group_end();
        }

        $this->db->where("b.create_by", $user_id);

        $query = $this->db->get();
    
        if ($query === false) {
            return false;
        }

        return $query->num_rows();
    }

}
