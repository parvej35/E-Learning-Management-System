<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Study extends CI_Controller {

    function __construct() {
        parent::__construct();  
    }

    function index(){ 
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $session_user_id = @$_SESSION["session_user_id"];
        if(is_null($session_user_id) || $session_user_id == "") {
            $this->load->view('login.php');
        } else {

            $data['title'] = "Study";
            $data["course_list"] = $this->common_model->get_course_list();

            $this->load->view('study', $data); 
        }           
    }

    function search_question(){
        if(!isset($_SESSION)) { 
            session_start();
        } 
        
        $session_user_id = @$_SESSION["session_user_id"];
        if(is_null($session_user_id) || $session_user_id == "") {
            $this->load->view('login.php');
        } else {
            
            $course_id = $this->input->post('course_id');
            $lesson_id = $this->input->post('lesson_id');

            $srt_query = "SELECT title, answer_1, answer_2, answer_3, answer_4, right_answer FROM questionnaire WHERE lesson_id = ".$lesson_id." ORDER BY id";                
            
            $query = $this->db->query($srt_query);
            $result = $query->result();

            $table_data = "";

            $counter = 0;
            foreach ($result as $questionnaire){
                $counter++;

                $title = $questionnaire->title;
                $right_answer = $questionnaire->right_answer;

                if($right_answer == 1){
                    $right_answer = $questionnaire->answer_1;                
                } else if($right_answer == 2){
                    $right_answer = $questionnaire->answer_2;                
                } else if($right_answer == 3){
                    $right_answer = $questionnaire->answer_3;                
                } else if($right_answer == 4){
                    $right_answer = $questionnaire->answer_4;                
                } else {
                    $right_answer = "";//default 
                }

                $table_data .= "<tr><td style='text-align:center;'>".$counter."</td><td>".$title."</td><td>".$right_answer."</td></tr>";
            } 

            $data["is_error"] = "false";
            $data["table_data"] = $table_data;
            
            echo json_encode($data);
        }    
    }
}