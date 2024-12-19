<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public $user_id;

    function __construct() {
        parent::__construct(); 
        $this->db=$this->load->database('mini_stockeai',true);
        $this->load->library('auth');
        $this->load->library('lusers');
        $this->load->library('session');
        $this->load->model('Userm');
        $this->auth->check_admin_auth();
    }


  
#=============User Manage Company===============#
public function managecompany()
{
  $content = $this->lusers->manage_company();
        $this->template->full_admin_html_view($content);
}   
    #==============User page load============#


    

    public function adadmin()
    {
    $content = $this->lusers->useraddforms();
        $this->template->full_admin_html_view($content);
    }
    

 public function index( $cid = '' ) {
        $content = $this->lusers->index( $cid );
        $this->template->full_admin_html_view( $content );
    }


public function insert_admin_user()
    {
        $CI = & get_instance();
        $CI->load->model('Userm');
        $num_str = sprintf("%03d", mt_rand(1, 999));
        // $password=md5($_REQUEST['password']);
        $password = md5("gef" . $this->input->post('password',true));
        $uid = $_SESSION['user_id'];
        $cmpy_id = $this->input->post('companyid');
        $uname = $this->input->post('username');
        $email = $this->input->post('email',true);
        $exist_user = $CI->Userm->getDatas('user_login', '*', ['user_id' => $cmpy_id, 'username' => $uname]);
        $cmpy_detail = $CI->Userm->getDatas('company_information', '*', ['company_id' => $cmpy_id]);
        if(empty($exist_user)) {
            $data = array(
                'user_id' => $cmpy_id,
                'first_name' => $uname,
                'company_name' => $cmpy_detail[0]['company_name'],
                'address' => $cmpy_detail[0]['address'],
                'phone' => $cmpy_detail[0]['mobile'],
                'unique_id' => "AD".$_POST['companyid'].$num_str,
                'create_by' => $uid,
             );
            $this->db->insert('users', $data);
            $user_login = ['user_id' => $cmpy_id, 'username' => $uname, 'logo' => $cmpy_detail[0]['logo'], 'security_code' => $cmpy_detail[0]['mobile'], 'unique_id' => "AD".$_POST['companyid'].$num_str, 'password' => $password, 'user_type' => 2, 'email_id' => $email, 'cid' => $cmpy_id, 'u_type' => 2, 'create_by' => $uid];
            $CI->Userm->insertData('user_login', $user_login);
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect('User/adadmin');
        } else {
            $this->session->set_userdata(array('message' => display('account_already_exists')));
            redirect('User/adadmin');
        }
    }




// public function company_insert(){

//  if ($_FILES['image']['name']) {
          

//         $config['upload_path']    = 'my-assets/image/logo/';
//         $config['allowed_types']  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG'; 
//         $config['encrypt_name']   = TRUE;

//             $this->load->library('upload', $config);
//             if (!$this->upload->do_upload('image')) {
//                 $error = array('error' => $this->upload->display_errors());
//                 $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
//                 redirect(base_url('Admin_dashboard/edit_profile'));
//             } else {
//             $data = $this->upload->data();  
//             $logo = $config['upload_path'].$data['file_name']; 
//             $config['image_library']  = 'gd2';
//             $config['source_image']   = $logo;
//             $config['create_thumb']   = false;
//             $config['maintain_ratio'] = TRUE;
//             $config['width']          = 200;
//             $config['height']         = 200;
//             $this->load->library('image_lib', $config);
//             $this->image_lib->resize();
//             $logo =  $logo;

//             }
//         }
     
//             // insert Company information///////////////
    
//             $uid=$_SESSION['user_id'];
    
//             $data = array(
//                 'company_name'    =>$this->input->post('company_name',true),
//                 'email' => $this->input->post('email',true),
//                 'address'      => $this->input->post('address',true),
//                 'mobile'   => $this->input->post('mobile',true),
//                 'website'  => $this->input->post('website',true),
//                 'logo'       => $logo,
//                 'create_by'     => $uid,
//                 'status'     => 0
//             );
    
//              $this->db->insert('company_information',$data);
//               $cid= $this->db->insert_id();
         
//              $data1 = array(
//                 'create_by'     => $cid,
//              );
             
//              $this->db->insert('web_setting',$data1);

//              $data2 = array(
//                 'create_by'     => $cid,
//                  'uid'     => $cid
//              );
//              $this->db->insert('invoice_design',$data2);



//              $num_str = sprintf("%03d", mt_rand(1, 999));
//      $data = array(
            
//               'unique_id'  =>   "AD".$cid.$num_str,
               
             
//                 'create_by'     => $uid,
               
//             );
//              $insert=$this->db->insert('users',$data);
            
//              $data = array(
//                 'username'    =>$this->input->post('username',true),
                
//                 'password' => md5("gef" . $this->input->post('password',true)),
//               'unique_id'  =>   "AD".$cid.$num_str,
//                 'user_type'      => 1+1,
//                 'u_type'      => 1+1,
//                 'security_code'   => $this->input->post('mobile',true),
//                 'email_id'  => $this->input->post('user_email',true),
//                 'status'       =>0,
//                 'cid'     => $cid,
//                 'user_id' =>$cid,
//                 'create_by'     => $uid,
               
//             );
//              $insert=$this->db->insert('user_login',$data);
//     $data2 = array(
//                 'cid'     => $cid,
//                 'user_id' =>$cid,
//                 'create_by'     => $uid,
//             );
//             $insert=$this->db->insert('payslip_invoice_design',$data2);
//              if($insert)
//              {
//                 redirect('user/managecompany');
//              }
        
        
    
//     }
    
    


public function company_insert() {

        $CI = & get_instance();
        $CI->load->model( 'Userm' );

        $cmpy_id = $this->input->post( 'cmpy_id' );

        $logo = '';
        if ( $_FILES[ 'image' ][ 'name' ] ) {
            $config[ 'upload_path' ]    = 'my-assets/image/logo/';
            $config[ 'allowed_types' ]  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';

            $config[ 'encrypt_name' ]   = TRUE;

            $this->load->library( 'upload', $config );
            if ( !$this->upload->do_upload( 'image' ) ) {
                $error = array( 'error' => $this->upload->display_errors() );
                $this->session->set_userdata( array( 'error_message' => $this->upload->display_errors() ) );
                redirect( base_url( 'Admin_dashboard/edit_profile' ) );
            } else {
                $data = $this->upload->data();

                $logoname = $config[ 'upload_path' ].$data[ 'file_name' ];

                $config[ 'image_library' ]  = 'gd2';
                $config[ 'source_image' ]   = $logoname;
                $config[ 'create_thumb' ]   = false;
                $config[ 'maintain_ratio' ] = TRUE;
                $config[ 'width' ]          = 200;
                $config[ 'height' ]         = 200;
                $this->load->library( 'image_lib', $config );
                $this->image_lib->resize();
                $logo =  $logoname;
            }
        } else {
            $logo = $this->input->post( 'logo_image' );
        }

        // insert Company information///////////////
        $uid = $_SESSION[ 'user_id' ];
        $cmpy_name = $this->input->post( 'company_name', true );
        $mobile = $this->input->post( 'mobile', true );
        $uname = $this->input->post( 'username', true );

        $data = array(
            'company_name'    => $cmpy_name,
            'email' => $this->input->post( 'email', true ),
            'address'      => $this->input->post( 'address', true ),
            'mobile'   => $mobile,
            'website'  => $this->input->post( 'website', true ),
            'logo'       => $logo,
            'create_by'     => $uid,
            'status'     => 1,
            'c_city'      => $this->input->post( 'c_city', true ),
            'c_state'      => $this->input->post( 'c_state', true ),
            'c_zipcode'      => $this->input->post( 'zipcode', true ),
            'currency'      => $this->input->post( 'currency', true ),
            'subscription_fees'      => $this->input->post( 'subscription_fees', true ),
            'payment_mail'      => $this->input->post( 'mail', true ),
            'due_date'      => $this->input->post( 'due_date', true ),
            'payment_reminder_date'      => $this->input->post( 'payment_reminder_date', true ),
            'user_name'      => $uname,
            'password'      => $this->input->post( 'password', true ),
            'utype'      => $this->input->post( 'user_type', true ),
        );

        if ( !empty( $cmpy_id ) ) {

            $cid = $cmpy_id;
            $where = [ 'company_id' => $cid ];

            $CI->Userm->updateData( 'company_information', $data, $where );

            $CI->Userm->updateData( 'users', [ 'create_by' => $uid, 'company_name' => $cmpy_name, 'first_name' => $uname, 'phone' => $mobile, 'userlogo' => $logo ], [ 'user_id' => $cid ] );

            $user_data = [
                'username'  => $uname,
                'password' => md5( 'gef' . $this->input->post( 'password', true ) ),
                'logo' => $logo,
                'user_type'      => 1+1,
                'u_type'      => 1+1,
                'email_id'  => $this->input->post( 'user_email', true ),
                'create_by' => $uid,
            ];

            $CI->Userm->updateData( 'user_login', $user_data, [ 'user_id' => $cid ] );

            $CI->Userm->updateData( 'payslip_invoice_design', [ 'user_id' => $cid, 'create_by' => $uid ], [ 'cid' => $cid ] );

        } else {
            $this->db->insert( 'company_information', $data );
            $cid = $this->db->insert_id();

            $CI->Userm->insertData( 'web_setting', [ 'create_by' => $cid ] );

            $inv_data = [ 'create_by' => $cid, 'uid' => $cid ];
            $CI->Userm->insertData( 'invoice_design', $inv_data );

            $num_str = sprintf( '%03d', mt_rand( 1, 999 ) );
            $users_data = [ 'unique_id'  =>   'AD'.$cid.$num_str, 'company_name' => $cmpy_name, 'first_name' => $uname, 'phone' => $mobile, 'userlogo' => $logo, 'create_by' => $uid, 'user_id' => $cid ];
            $CI->Userm->insertData( 'users', $users_data );

            $user_data = array(
                'username'    =>$this->input->post( 'username', true ),
                'password' => md5( 'gef' . $this->input->post( 'password', true ) ),
                'unique_id'  =>   'AD'.$cid.$num_str,
                'user_type'      => 1+1,
                'u_type'      => 1+1,
                'security_code'   => $this->input->post( 'mobile', true ),
                'email_id'  => $this->input->post( 'user_email', true ),
                'status'       =>1,
                'cid'     => $cid,
                'user_id' =>$cid,
                'create_by'     => $uid,
            );
            $CI->Userm->insertData( 'user_login', $user_data );

            $payslip_info = [ 'cid' => $cid, 'user_id' => $cid, 'create_by' => $uid ];
            $CI->Userm->insertData( 'payslip_invoice_design', $payslip_info );
        }

        redirect( 'user/managecompany' );
    }

    public function company_insert_branch(){
  
        $uid=$_SESSION['user_id'];

    $data = array(
        'company_name'    =>$this->input->post('company_name',true),
        'email' => $this->input->post('email',true),
        'address'      => $this->input->post('address',true),
        'mobile'   => $this->input->post('mobile',true),
        'website'  => $this->input->post('website',true),

        'create_by'     => $uid,
        'status'     => 0
    );

    $insert=  $this->db->insert('company_information',$data);
     if($insert)
     {
        redirect('Company_setup/manage_company');
     }
    }


















public function add_user()
{


    

       $content = $this->lusers->ad_user();
        $this->template->full_admin_html_view($content);
    }



#==============Chnage Status=============#

    public function chnage_company_status($value,$id)
    {
       
     echo $sql='update company_information set status ="'.$value.'" where company_id='.$id;
     $query=$this->db->query($sql);
       echo $sql='update user_login set status ="'.$value.'" where cid='.$id;
     $query=$this->db->query($sql);
     if($query)
    {
          redirect('user/managecompany');
    }


    }
    #===============User Search Item===========#

 public function company_edit($id){


  $sql='select * from company_information where company_id='.$id;
 $query=$this->db->query($sql);
$row=$query->result_array();  
  $sql='select * from user_login where cid='.$id;
 $query=$this->db->query($sql);
$row1=$query->result_array(); 
   
    $data=array(
        'company_info'=>$row,
        'user_info'=>$row1,
);
 
   $content = $this->lusers->company_edit_form($data);
        
 $this->template->full_admin_html_view($content);


 }
public function company_update()
{

}


public function insert_users()
{

$password=md5('gef'.$_POST['password']);


      $sql='select * from user_login
      where user_id='.$_SESSION['user_id'];
    $query=$this->db->query($sql);
    $row=$query->result_array();


     $cid=$row[0]['cid'];
     
     // print_r($_REQUEST);    
     
$sql='SELECT * FROM `users` ORDER BY `id` DESC';
$query=$this->db->query($sql);
    
    $row=$query->result_array();
  $finalid=$row[0]['id']+1;
 $id=$this->db->insert_id();
    $num_str = sprintf("%03d", mt_rand(1, 999));
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $combinedValue = isset($_POST['employee_name']) ? $_POST['employee_name'] : ''; // Check if set to avoid Undefined index error
    $splitValues = explode(' ', $combinedValue);
    if (count($splitValues) >= 3) {
        $id = $splitValues[0];
        $first_name = $splitValues[1];
        $last_name = $splitValues[2];
        $data = array(
            'last_name' => $last_name,   // Corrected to use $last_name
            'first_name' => $first_name, // Corrected to use $first_name
            'employee_id' => $id,        // Corrected to use $id
            'company_name' => $_SESSION['user_id'],
            'phone' => $_POST['phone'],
            'user_id' => $_SESSION['user_id'],
            'gender' => $_POST['gender'],
            'unique_id' => "UD" . $_SESSION['user_id'] . $num_str,
            'date_of_birth' => $_POST['Date'],
            'create_by' => $_SESSION['user_id']
        );
        $this->db->insert('users', $data);
    }
}
    
    
    
//      $sql='insert into users(

//   last_name,
//   first_name,
//   company_name,
//   phone,
//   user_id,
//   gender,
//   unique_id,
//   date_of_birth,
// create_by

//   )

//   values(

//   "'.$_POST['lname'].'",
//   "'.$_POST['fname'].'",            
//   "'.$_SESSION['user_id'].'",            
//   "'.$_POST['phone'].'",    
//   "'.$_SESSION['user_id'].'",   
//   "'.$_POST['gender'].'",    
//  "'."UD".$_SESSION['user_id'].$num_str.'",
//   "'.$_POST['Date'].'" , 
//   "'.$_SESSION['user_id'].'" 
//   )

//   ';
   
   // $this->db->query($sql);

  

$query='insert into user_login(
    
    username,
    password,
    unique_id,
    user_id,
    u_type,
    email_id,
    user_delete_id,
    cid
)

values(
    "'.$_POST['username'].'",
    "'.$password.'",
    "'."UD".$_SESSION['user_id'].$num_str.'",
    "'.$_SESSION['user_id'].'",
    "3",
    "'.$_POST['email'].'",
    "'.$id.'",
    "'.$_SESSION['user_id'].'"
    
) ';

  $this->db->query($query);

$this->session->set_userdata(array('message' => display('successfully_added')));
    redirect('User/manage_user');

}

 
    public function user_search_item() {
        $user_id = $this->input->post('user_id');
        $content = $this->lusers->user_search_item($user_id);
        $this->template->full_admin_html_view($content);
    }

    #================Manage User===============#

    public function manage_user() {
        $content = $this->lusers->user_list();
        $this->template->full_admin_html_view($content);
    }


    #==============Add  Company and admin user==============#


    #==============Insert User==============#

    public function insert_user() {
        $this->load->library('upload');
        if (($_FILES['logo']['name'])) {
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = 'assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = true;

            $this->upload->initialize($config);
              if (!$this->upload->do_upload('logo')) {
                $data['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('user');
            } else {
                $view = $this->upload->data();
                $logo = base_url($config['upload_path'] . $view['file_name']);
            }
            
        }
        $data = array(
            'user_id'    => $this->generator(15),
            'first_name' => $this->input->post('first_name',true),
            'last_name'  => $this->input->post('last_name',true),
            'email'      => $this->input->post('email',true),
            'password'   => md5("gef" . $this->input->post('password',true)),
            'user_type'  => $this->input->post('user_type',true),
            'logo'       => (!empty($logo)?$logo:base_url().'assets/dist/img/profile_picture/profile.jpg'),
            'status'     => 1
        );

        $this->lusers->insert_user($data);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if (isset($_POST['add-user'])) {
            redirect('User/manage_user');
        } elseif (isset($_POST['add-user-another'])) {
            redirect(base_url('User/manage_user'));
        }
    }

    #===============User update form================#

    public function user_update_form($user_id) {
        $user_id = $user_id;
        $content = $this->lusers->user_edit_data($user_id);
        $this->template->full_admin_html_view($content);
    }

    #===============User update===================#

    public function user_update() {
      $this->load->library('upload');
        if (($_FILES['logo']['name'])) {
            $files = $_FILES;
            $config = array();
            $config['upload_path'] = 'assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = true;

            $this->upload->initialize($config);
              if (!$this->upload->do_upload('logo')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('user');
            } else {
                $view = $this->upload->data();
                $logo = base_url($config['upload_path'] . $view['file_name']);
            }
        }
        $user_id = $this->input->post('user_id');
        $data['user_id'] = $user_id;
        $data['logo']   = $logo;
        $this->Userm->update_user($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('User/manage_user'));
    }


   
    #============User delete===========#

    public function user_delete($user_id) {
        $this->Userm->delete_user($user_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
      redirect(base_url('User/manage_user'));
    }

    // Random Id generator
    public function generator($lenth) {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 61);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    #============User delete===========#

    public function addusers() { 

         $content = $this->lusers->addusers();
        $this->template->full_admin_html_view($content);
    }

 public function edit_user($id)
 {
    $content = $this->lusers->edit_user($id);
        $this->template->full_admin_html_view($content);
 }

}
