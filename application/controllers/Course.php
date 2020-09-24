<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('Course_model','course');
	}

    function index() {
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
            $data['title'] = "Course";
            $this->load->view('admin/course.php', $data);               
        }
    }

    
    function save(){
        if(!isset($_SESSION)) {
            session_start();
        }

        $is_admin = @$_SESSION["session_user_is_admin"];

        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else{            
            
            $this->form_validation->set_rules('name', 'name', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data["is_error"] = "true";
                $data['message'] = 'Failed to save information due to invalid input';
            }else{
                $course_id = $this->input->post('id');

                $name = $this->input->post('name');
                $name = htmlspecialchars($name, ENT_QUOTES);

                if($course_id == "") { //create event 
                    
                    $str_query = "SELECT id FROM course WHERE LOWER(name) = '".$name."' AND status = 1";
                    $query = $this->db->query($str_query);
                    $count_existing =  $query->num_rows();
                    if($count_existing > 0){
                        $data["is_error"] = "true";
                        $data['message'] = 'Same course name already exists.';
                        echo json_encode($data);  
                        die;
                    }

                    $param_data = array(
                        'name' => $name,
                        'status' => 1
                    );
                    $this->db->insert('course', $param_data);

                    $data["is_error"] = "false";
                    $data['message'] = 'New course information saved.';
                    
                } else {//update event

                    $str_query = "SELECT id FROM course WHERE LOWER(name) = '".$name."' AND status = 1 AND id <> ".$course_id;
                    $query = $this->db->query($str_query);
                    $count_existing =  $query->num_rows();
                    if($count_existing > 0){
                        $data["is_error"] = "true";
                        $data['message'] = 'Same course name already exists.';
                        echo json_encode($data);  
                        die;
                    }

                    $param_data = array(
                        'name' => $name
                    );

                    $this->db->where('id', $course_id);
                    $this->db->update('course', $param_data);

                    $data["is_error"] = "false";
                    $data['message'] = 'Course information updated.';
                }              
            }
            echo json_encode($data);            
        }
    }

    function delete(){
        if(!isset($_SESSION)) {
            session_start();
        }

        $is_admin = @$_SESSION["session_user_is_admin"];

        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else{            
            
            $course_id = $this->input->get('id');

            if($course_id == "") { 
                
                $data["is_error"] = "true";
                $data['message'] = 'Failed to delete course information.Please try again.';

            } else {

                $str_query = "SELECT id FROM lesson WHERE course_id = ".$course_id;
                $query = $this->db->query($str_query);
                $count =  $query->num_rows();
                if($count > 0){
                    $data["is_error"] = "true";
                    $data['message'] = $count.' lessons are associated with this course.';
                    echo json_encode($data);  
                    die;
                }
                
                $param_data = array(
                    'status' => 0
                );

                $this->db->where('id', $course_id);
                $this->db->update('course', $param_data);

                $data["is_error"] = "false";
                $data['message'] = 'Course information deleted.';
            } 

            echo json_encode($data);            

        }
    }

    function populate_list(){
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        
        $is_admin = @$_SESSION["session_user_is_admin"];

        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        }

        $list = $this->course->get_list();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $course) {
            $no++;
            $row = array();

            $row[] = $course->id;
            $row[] = $course->name;
            
            $row[] = '<a class="btn btn-xs btn-info" href="#" title="Edit" onclick="show_course('.$course->id.')"><i class="fa fa-check-circle"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-xs btn-danger" href="#" title="Delete" onclick="delete_course('.$course->id.')"><i class="fa fa-close"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->course->count_all(),
                "recordsFiltered" => $this->course->count_filtered_list(),
                "data" => $data,
        );
        
        echo json_encode($output);
    }

    function get_by_id(){ 
        if(!isset($_SESSION)) { 
            session_start();
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];

        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
            $course_id = $_GET['id'];

            if($course_id == "") {
                $data["is_error"] = "true";
                $data["message"] = "Faild to get course information. Refresh the page.";
            } else {

                $course_obj = $this->course->get_by_id($course_id);
                
                $data["name"] = $course_obj->name;
                $data["is_error"] = "false";
            }
            
            echo json_encode($data);

        }
    }
}
