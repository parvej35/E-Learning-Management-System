<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_user extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function save(){

        $this->form_validation->set_rules('fullname','Fullname','required');
        $this->form_validation->set_rules('signuppassword','Password','required');
        $this->form_validation->set_rules('resignuppassword','Password Confirmation','required');
        $this->form_validation->set_rules('signupemail','Email','required');

        if ($this->form_validation->run() == FALSE) {
            $data["is_error"] = "true";
            $data['message'] = "Failed to create user account due to invalid input.";
            echo json_encode($data);
            die;
        } else {        
            $fullname = $this->input->post('fullname');
            $password = $this->input->post('signuppassword');
            $email = $this->input->post('signupemail');

            $fullname = @trim($fullname);
            $password = @trim($password);
            $email = @trim($email);

            $fullname = htmlspecialchars($fullname, ENT_QUOTES);
            $password = htmlspecialchars($password, ENT_QUOTES);
            $email = htmlspecialchars($email, ENT_QUOTES);

            $this->db->select('id');
            $this->db->from('app_user');
            $this->db->where('status', 1);
            $this->db->where('email', $email);
            $count_existing_user = $this->db->count_all_results();
            if($count_existing_user > 0){
                $data["is_error"] = "true";
                $data['message'] = 'This email has already been registered';
                echo json_encode($data);
                die;
            }

            $password = $this->encryption->encrypt($password);
            
            $registered_on = Date("Y-m-d H:i:s", now());

            $param = array(
                'email' => $email,
                'full_name' => $fullname,
                'user_password' => $password,
                'registered_on' => $registered_on,
                'status' => 1,
                'is_admin' => 0
            );
            $this->db->insert('app_user', $param);

            $data["is_error"] = "false";                
            $data["message"] = "Congratulations! Your account successfully created.";
        
            echo json_encode($data);
        }   
    }


    function list(){ 
        if(!isset($_SESSION)) { 
            session_start();
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];

        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
        
            $STR_QUERY = "SELECT au.email, au.full_name, DATE_FORMAT(au.registered_on, '%d-%b-%Y at %H:%i:%s') AS registered_on, COUNT(er.id) AS total_test  FROM app_user au LEFT JOIN evaluation_report er ON er.app_user_id = au.id GROUP BY au.email, au.full_name, registered_on ORDER BY au.full_name ASC";

            $query = $this->db->query($STR_QUERY);
            $app_user_list = $query->result();

            $app_user_info = "";
            for ($i = 0; $i < count($app_user_list); $i++) {
                $app_user = $app_user_list[$i];

                $full_name = $app_user->full_name;  
                $email = $app_user->email;                
                $registered_on = $app_user->registered_on; 
                $total_test = $app_user->total_test; 

                $app_user_info .= "<tr><td style='text-align: center;'>".($i + 1)."</td><td>".$full_name."</td><td>".$email."</td><td style='text-align: center;'>".$registered_on."</td><td style='text-align: center;'>".$total_test."</td></tr>";
            }

            $data["app_user_info"] = $app_user_info;

            $this->load->view('admin/app_user_list', $data);
        }
    }

    
}