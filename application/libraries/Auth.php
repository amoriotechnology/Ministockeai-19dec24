<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '../vendor/autoload.php';
use Firebase\JWT\JWT;
class Auth {
  public function __construct() {
    // Get the CI instance
    $CI =& get_instance();

    // Load the database for the 'mini_stockeai' group
    $this->db = $CI->load->database('mini_stockeai', true);

    // Load the session library
    $CI->load->library('session');
}

public function login($username, $password) {
   

    // Load the Users model using CI instance
    $CI =& get_instance();
    $CI->load->model('Users');

    // Call the check_valid_user method from Users model
    $result = $CI->Users->check_valid_user($username, $password);
  

    if ($result[0]['user_type'] == 1) {
        $checkPermission = $CI->Users->userPermissionadmin($result[0]['user_id']);
    } else {
        $checkPermission = $CI->Users->userPermission($result[0]['user_id']);
    }

    // Process permissions
    $permission = array();
    if (!empty($checkPermission)) {
        foreach ($checkPermission as $value) {
            $permission[$value->directory] = array(
                'create' => $value->create,
                'read'   => $value->read,
                'update' => $value->update,
                'delete' => $value->delete
            );
        }
    }

    if ($result) {
        $key = md5(time());
        $key = str_replace("1", "z", $key);
        $key = str_replace("2", "J", $key);
        $key = str_replace("3", "y", $key);
        $key = str_replace("4", "R", $key);
        $key = str_replace("5", "Kd", $key);
        $key = str_replace("6", "jX", $key);
        $key = str_replace("7", "dH", $key);
        $key = str_replace("8", "p", $key);
        $key = str_replace("9", "Uf", $key);
        $key = str_replace("0", "eXnyiKFj", $key);
        $sid_web = substr($key, rand(0, 3), rand(28, 32));

        // Query to get company role data
        $sql2 = 'SELECT * FROM company_assignrole WHERE user_id = "' . $result[0]['user_id'] . '"';
        $query = $CI->db->query($sql2);

        $row = $query->result_array();
        $nums = $query->num_rows();
        if ($nums > 0) {
            $roleid = $row[0]['roleid'];
            $sql2 = 'SELECT GROUP_CONCAT(CONCAT(`menu`, " - ", `create`) SEPARATOR ", ") AS items FROM super_permission WHERE role_id = "' . $roleid . '"';
            $query = $CI->db->query($sql2);
            $row2 = $query->result_array();

            foreach ($row2 as $val1) {
                foreach ($val1 as $admin_data) {
                    $admin_data = explode(',', $admin_data);
                    $CI->session->set_userdata('admin_data', $admin_data);  // Use CI instance
                }
            }
        }

        // Store user data in session
        $user_data = array(
            'sid_web'           => $sid_web,
            'isLogIn'           => true,
            'isAdmin'           => (($result[0]['user_type'] == 1) ? true : false),
            'user_id'           => $result[0]['user_id'],
            'user_type'         => $result[0]['user_type'],
            'unique_id'         => $result[0]['unique_id'],
            'user_name'         => $result[0]['username'],
            'root'              => 'stockeai',
            'permission'        => json_encode($CI->session->userdata('admin_data'))
        );

        // Set session data
        $CI->session->set_userdata($user_data);
        $CI->session->set_userdata('user_id', $result[0]['user_id']);
        $CI->session->set_userdata('unique_id', $result[0]['unique_id']);

        // Generate JWT
        $token = $this->generate_token($user_data);

        // Insert token into database
        $insert_data = array(
            'user_id'   => $result[0]['user_id'],
            'unique_id' => $result[0]['unique_id'],
            'jwt_token' => $token,
            'created_at'=> date('Y-m-d H:i:s'),
        );

        $CI->load->model('Web_settings');
        $CI->Web_settings->insert_token($insert_data);
    } else {
        echo json_encode(['error' => 'Invalid credentials']);
    }
}
public function generate_token($data) {
    $CI =& get_instance();
    $CI->load->config('config');
    $CI->load->database(); // Load the database library if not already loaded
    $secret_key = $CI->config->item('jwt_secret_key');

    if (empty($data)) {
        // Return a token that will fail validation in Wagers
        return JWT::encode(['iat' => time(), 'exp' => time() - 1], $secret_key, 'HS256');
    }

    // Proceed with normal token generation if data is provided
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;
    $payload = [
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => [
            'sid_web'    => $data['sid_web'],
            'user_id'    => $data['user_id'],
            'user_type'  => $data['user_type'],
            'user_name'  => $data['user_name'],
            'unique_id'  => $data['unique_id'],
            'permission' => $data['permission'],
        ]
    ];

    $token = JWT::encode($payload, $secret_key, 'HS256');

    // Insert the token into the tokens table
  

   

    return $token;
}


    public function is_logged()
    {
        $CI =& get_instance();
        if($CI->session->userdata('sid_web'))
        {
            return true;
        }
        return false;
    }

 public function logout()
    { 
        $CI =& get_instance(); 
        $user_data = array(
                'sid_web'       => '',
                'user_id'       => '',
                'user_type'     => '',
                'user_name'     => ''
            );
    
         $update_data = [ 'expired' => 1];
    $CI->db->where('user_id', $CI->session->userdata('user_id'));
    $CI->db->where('unique_id',  $CI->session->userdata('unique_id'));
    $CI->db->update('jwt_tokens', $update_data);
   
      $CI->session->sess_destroy();
        return true;
    }
    
    public function is_admin()
    {
        // || $CI->session->userdata('user_type')==2
        $CI =& get_instance();
        if ($CI->session->userdata('user_type')==1)
        {
            return true;
        }
        return true;
    }
    function check_admin_auth($url='')
    {   
        if($url==''){$url = base_url().'Admin_dashboard/login';}
        $CI =& get_instance();
        if ((!$this->is_logged()) || (!$this->is_admin()))
        { 
            $this->logout();
            $error = "You are not authorized for this part";
            $CI->session->set_userdata(array('error_message'=>$error));
            redirect($url,'refresh'); exit;
        }
    }
    
    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
    
        for($i=0; $i<$lenth; $i++)
        {
            $rand_value=rand(0,34);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }

}



?>