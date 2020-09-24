<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson extends CI_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('Lesson_model','lesson');
	}

    function index() {
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
            $data['title'] = "Lesson";
            $data["course_list"] = $this->common_model->get_course_list();

            $this->load->view('admin/lesson.php', $data);               
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
            $this->form_validation->set_rules('course_id', 'course_id', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data["is_error"] = "true";
                $data['message'] = 'Failed to save information due to invalid input';
            } else { 

                $lesson_id = $this->input->post('id');

                $name = $this->input->post('name');
                $name = htmlspecialchars($name, ENT_QUOTES);

                $course_id = $this->input->post('course_id');

                if($lesson_id == "") { //create event           
            
                    $str_query = "SELECT id FROM lesson WHERE LOWER(name) = '".$name."' AND course_id = ".$course_id." AND status = 1";

                    $query = $this->db->query($str_query);
                    $count_existing =  $query->num_rows();
                    if($count_existing > 0){
                        $data["is_error"] = "true";
                        $data['message'] = 'Same lesson already exists.';
                        echo json_encode($data);  
                        die;
                    }

                    $param_data = array(
                        'status' => 1,
                        'name' => $name,
                        'course_id' => $course_id,
                    );

                    $this->db->insert('lesson', $param_data);

                    $data["is_error"] = "false";
                    $data['message'] = 'New lesson information saved.';   

                } else {

                    $str_query = "SELECT id FROM lesson WHERE LOWER(name) = '".$name."' AND course_id = ".$course_id." AND status = 1 AND id <> ".$lesson_id;

                    $query = $this->db->query($str_query);
                    $count =  $query->num_rows();
                    if($count > 0){
                        $data["is_error"] = "true";
                        $data['message'] = 'Same lesson name already exists.';
                        echo json_encode($data);  
                        die;
                    }

                    $param_data = array(
                        'name' => $name,
                        'course_id' => $course_id
                    );

                    $this->db->where('id', $lesson_id);
                    $this->db->update('lesson', $param_data);

                    $data["is_error"] = "false";
                    $data['message'] = 'Lesson information updated.';
                }               
                
                echo json_encode($data);            
            }
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
            
            $lesson_id = $this->input->get('id');

            if($lesson_id == "") { 
                
                $data["is_error"] = "true";
                $data['message'] = 'Failed to delete lesson information. Please try again.';

            } else {

                $str_query = "SELECT id FROM questionnaire WHERE lesson_id = ".$lesson_id;
                $query = $this->db->query($str_query);
                $count =  $query->num_rows();
                if($count > 0){
                    $data["is_error"] = "true";
                    $data['message'] = $count.' questions are associated with this lesson.';
                    echo json_encode($data);  
                    die;
                }
                
                $param_data = array(
                    'status' => 0
                );

                $this->db->where('id', $lesson_id);
                $this->db->update('lesson', $param_data);

                $data["is_error"] = "false";
                $data['message'] = 'Lesson information deleted.';
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

        $list = $this->lesson->get_list();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lesson) {
            $no++;
            $row = array();

            $row[] = $lesson->id;
            
            $row[] = $lesson->course_name;
            $row[] = $lesson->lesson_name;

            
            $row[] = '<a class="btn btn-xs btn-info" href="#" title="Edit" onclick="show_lesson('.$lesson->id.')"><i class="fa fa-check-circle"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-xs btn-danger" href="#" title="Delete" onclick="delete_lesson('.$lesson->id.')"><i class="fa fa-close"></i> Delete</a>';

        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lesson->count_all(),
            "recordsFiltered" => $this->lesson->count_filtered_list(),
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
            $lesson_id = $_GET['id'];

            if($lesson_id == "") {
                $data["is_error"] = "true";
                $data["message"] = "Faild to get lesson information. Refresh the page.";
            } else {

                $lesson_obj = $this->lesson->get_by_id($lesson_id);
                
                $data["id"] = $lesson_obj->id;
                $data["name"] = $lesson_obj->name;
                $data["course_id"] = $lesson_obj->course_id;

                $data["is_error"] = "false";
            }
            
            echo json_encode($data);

        }
    }

    function get_list_by_course_id() {
        

        $course_id = @$_GET['course_id'];
        
        if($course_id == "") {
            $data["is_error"] = "true";
            $data["message"] = "Faild to get lesson information. Refresh the page.";
        } else {

            $result = $this->lesson->get_list_by_course_id($course_id);

            $lesson_list = "<option value='0'>-- Select --</option>";

            foreach ($result as $lesson){
                $id = $lesson->id;
                $name = $lesson->name;
                
                $lesson_list .= "<option value='".$id."'>".$name."</option>";
            }             
            
            $data["is_error"] = "false";
            $data["lesson_list"] = $lesson_list;
        }    

        echo json_encode($data);
    }
}
