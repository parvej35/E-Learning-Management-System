<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questionnaire extends CI_Controller {    

    function __construct() {
        parent::__construct();  
        $this->load->model('Questionnaire_model','questionnaire');
    }

    function index(){ 
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
            
            $data["course_list"] = $this->common_model->get_course_list();

            $data['title'] = "Generate Question";
            $this->load->view('admin/question', $data);
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

        $list = $this->questionnaire->get_list();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $questionnaire) {
            $no++;
            $row = array();
            
            $row[] = $questionnaire->id;
            
            $row[] = $questionnaire->course_name;
            $row[] = $questionnaire->lesson_name;
            $row[] = $questionnaire->title;
            
            $right_answer = $questionnaire->right_answer;

            if($right_answer == "1"){
                $row[] = "<b style='color:#900C3F;'>".$questionnaire->answer_1."</b>";
            } else if($right_answer == "2"){
                $row[] = "<b style='color:#900C3F;'>".$questionnaire->answer_2."</b>";
            } else if($right_answer == "3"){
                $row[] = "<b style='color:#900C3F;'>".$questionnaire->answer_3."</b>";
            } else if($right_answer == "4"){
                $row[] = "<b style='color:#900C3F;'>".$questionnaire->answer_4."</b>";
            } 

            $row[] = "<a class='btn btn-xs btn-success' href='javascript:void();'' title='Show' onclick='show_info_to_edit(".$questionnaire->id.")'>Show</a>";
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->questionnaire->count_all(),
            "recordsFiltered" => $this->questionnaire->count_filtered_list(),
            "data" => $data,
        );
        
        echo json_encode($output);
        
    }

    function save(){

        if(!isset($_SESSION)) { 
            session_start();
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {
            
            $this->form_validation->set_rules('course_id', 'course_id', 'required');
            $this->form_validation->set_rules('lesson_id', 'lesson_id', 'required');
            $this->form_validation->set_rules('title', 'title', 'required');
            $this->form_validation->set_rules('answer_1', 'answer_1', 'required');
            $this->form_validation->set_rules('answer_2', 'answer_2', 'required');
            $this->form_validation->set_rules('answer_3', 'answer_3', 'required');
            $this->form_validation->set_rules('answer_4', 'answer_4', 'required');
            $this->form_validation->set_rules('right_answer', 'right_answer', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $data["is_error"] = "true";
                $data['message'] = 'Failed to save questionnaire due to invalid input';
            } else {
                $course_id = $_POST['course_id'];
                $lesson_id = $_POST['lesson_id'];

                $title = @trim($_POST['title']);
                $title = htmlspecialchars($title, ENT_QUOTES);     

                $answer_1 = @trim($_POST['answer_1']);
                $answer_1 = htmlspecialchars($answer_1, ENT_QUOTES);     

                $answer_2 = @trim($_POST['answer_2']);
                $answer_2 = htmlspecialchars($answer_2, ENT_QUOTES); 

                $answer_3 = @trim($_POST['answer_3']);
                $answer_3 = htmlspecialchars($answer_3, ENT_QUOTES); 

                $answer_4 = @trim($_POST['answer_4']);
                $answer_4 = htmlspecialchars($answer_1, ENT_QUOTES); 
                
                $right_answer = $_POST['right_answer'];

                $str_query = "SELECT id FROM questionnaire WHERE LOWER(title) = '".$title."' AND status = 1";
                $query = $this->db->query($str_query);
                $count_existing =  $query->num_rows();
                if($count_existing > 0){
                    $data["is_error"] = "true";
                    $data['message'] = 'Same question already exists.';

                    echo json_encode($data);  
                    die;
                }

                $param_data = array(
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'title' => $title,
                    'answer_1' => $answer_1,
                    'answer_2' => $answer_2,
                    'answer_3' => $answer_3,
                    'answer_4' => $answer_4,
                    'right_answer' => $right_answer,
                    'status' => 1
                );
                $this->db->insert('questionnaire', $param_data);

                $data["is_error"] = "false";
                $data['message'] = 'New questionnaire successfully saved.';
            }

            echo json_encode($data);
        }    
    }

    function get_details_info(){
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {

            $questionnaire_id = $_GET['questionnaire_id'];

            $id = $category_id = $sub_category_1_id = $sub_category_2_id = $sub_category_3_id = $difficulty_level_id = $ques_in_bn = $ques_in_en = $answer_1 = $answer_2 = $answer_3 = $answer_4 = $right_answer = $academy_class_id = $academy_subject_id = $academy_chapter_id = $admission_category_id = $past_year_ques_set_id = $status = "0";

            $this->db->select('id, course_id, lesson_id, right_answer, title, answer_1, answer_2, answer_3, answer_4');
            $this->db->from('questionnaire');
            $this->db->where('status', 1);
            $this->db->where('id', $questionnaire_id);
            
            $result = $this->db->get();

            $data["id"] = $result->row()->id;
            $data["course_id"] = $result->row()->course_id;
            $data["lesson_id"] = $result->row()->lesson_id;
            $data["title"] = $result->row()->title;
            $data["answer_1"] = $result->row()->answer_1;
            $data["answer_2"] = $result->row()->answer_2;
            $data["answer_3"] = $result->row()->answer_3;
            $data["answer_4"] = $result->row()->answer_4;
            $data["right_answer"] = $result->row()->right_answer;

            $this->load->model('Lesson_model','lesson');
                
            $result = $this->lesson->get_list_by_course_id($result->row()->course_id);
            
            $lesson_list = "<option value='0'>-- Select --</option>";
            foreach ($result as $lesson){
                $id = $lesson->id;
                $name = $lesson->name;
                $lesson_list .= "<option value='".$id."'>".$name."</option>";
            }

            $data["lesson_list"] = $lesson_list;
            $data["is_error"] = "false";   

            echo json_encode($data);
        }    
    }

    function update(){
        if(!isset($_SESSION)) { 
            session_start();
        } 

        $is_admin = @$_SESSION["session_user_is_admin"];
        if(is_null($is_admin) || $is_admin == "" || $is_admin != 1) {
            $this->load->view('login.php');
        } else {

            $this->form_validation->set_rules('questionnaire_id', 'questionnaire_id', 'required');    
            $this->form_validation->set_rules('update_course_id', 'update_course_id', 'required');
            $this->form_validation->set_rules('update_lesson_id', 'update_lesson_id', 'required');
            $this->form_validation->set_rules('update_title', 'update_title', 'required');
            $this->form_validation->set_rules('update_answer_1', 'update_answer_1', 'required');
            $this->form_validation->set_rules('update_answer_2', 'update_answer_2', 'required');
            $this->form_validation->set_rules('update_answer_3', 'update_answer_3', 'required');
            $this->form_validation->set_rules('update_answer_4', 'update_answer_4', 'required');
            $this->form_validation->set_rules('update_right_answer', 'update_right_answer', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data["is_error"] = "true";
                $data['message'] = 'Failed to update questionnaire due to invalid input';
            }else{
                
                $questionnaire_id = $_POST['questionnaire_id'];

                $course_id = $_POST['update_course_id'];
                $lesson_id = $_POST['update_lesson_id'];

                $title = @trim($_POST['update_title']);
                $title = htmlspecialchars($title, ENT_QUOTES);     

                $answer_1 = @trim($_POST['update_answer_1']);
                $answer_1 = htmlspecialchars($answer_1, ENT_QUOTES);     

                $answer_2 = @trim($_POST['update_answer_2']);
                $answer_2 = htmlspecialchars($answer_2, ENT_QUOTES); 

                $answer_3 = @trim($_POST['update_answer_3']);
                $answer_3 = htmlspecialchars($answer_3, ENT_QUOTES); 

                $answer_4 = @trim($_POST['update_answer_4']);
                $answer_4 = htmlspecialchars($answer_1, ENT_QUOTES); 
                
                $right_answer = $_POST['update_right_answer'];

                $param_data = array(
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'title' => $title,
                    'answer_1' => $answer_1,
                    'answer_2' => $answer_2,
                    'answer_3' => $answer_3,
                    'answer_4' => $answer_4,
                    'right_answer' => $right_answer
                );

                $this->db->where('id', $questionnaire_id);
                $this->db->update('questionnaire', $param_data);

                $data["is_error"] = "false";
                $data['message'] = 'Information successfully updated.';

            }
            
            echo json_encode($data);
        }    
    }
}