<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_test extends CI_Controller {

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

            $data['title'] = "Exam";
            $data["course_list"] = $this->common_model->get_course_list();

            $this->load->view('model_test/search', $data);
        }           
    }

    function exam(){ 
        if(!isset($_SESSION)) { 
            session_start();
        } 
        
        $session_user_id = @$_SESSION["session_user_id"];
        if(is_null($session_user_id) || $session_user_id == "") {
            $this->load->view('login.php');
        } else {
            
            $course_id = $this->input->get('course_id');
            $lesson_id = $this->input->get('lesson_id');

            $srt_query = "SELECT id, title, answer_1, answer_2, answer_3, answer_4, right_answer FROM questionnaire WHERE lesson_id = ".$lesson_id." AND status = 1";

            $ques_ans = $this->db->query($srt_query);
            $data['ques_ans'] = $ques_ans->result_array();  

            if(count($data['ques_ans']) == 0) {
                $data['title'] = "Exam";
                $data['message'] = "No question found.";   
                $data["course_list"] = $this->common_model->get_course_list();

                $this->load->view('model_test/search', $data);
            } else {

                $data['course_id'] = $course_id;     
                $data['lesson_id'] = $lesson_id;     

                $this->load->view('model_test/exam', $data);
            }    
        } 

        
    }

    function evaluate(){
        if(!isset($_SESSION)) { 
            session_start();
        } 

        $session_user_id = @$_SESSION["session_user_id"];
        if(is_null($session_user_id) || $session_user_id == "") {
            $this->load->view('login.php');
        } else {

            $data["is_error"] = "true";

            $this->form_validation->set_rules('course_id', 'course_id', 'required');
            $this->form_validation->set_rules('lesson_id', 'lesson_id', 'required');
            $this->form_validation->set_rules('selected_answer', 'selected_answer', 'required');
            $this->form_validation->set_rules('exam_ques_ids', 'exam_ques_ids', 'required');

            if ($this->form_validation->run() == FALSE) {

                $data["is_error"] = "true";
                $data['message'] = 'Failed to evaluate due to invalid input';

                echo json_encode($data);
                die;
            } else{

                $course_id = $this->input->post('course_id');
                $lesson_id = $this->input->post('lesson_id');
                
                $exam_ques_ids = $_POST['exam_ques_ids']; //quesIDE.G: 234,2,34,3
                // echo $exam_ques_ids;

                $selected_answer = $_POST['selected_answer']; //quesID_ansNo E.G: 234_2,34_3
                $answer_arr = explode(DELIM_COMA, $selected_answer);
                
                $evaluation_summary = $str_given_answer = "";
                $counter = $correct_answer = $wrong_answer = $not_answered = $total_obtained_marks = 0;

                $exam_ques_ids = explode(DELIM_COMA, $exam_ques_ids);//convert "," seperated string into array

                foreach($exam_ques_ids as $ques_id){

                    if($ques_id == "") continue;


                    $given_ans = 0;

                    for($i = 0; $i < sizeof($answer_arr); $i++){
                        $single_ans_arr = explode(DELIM_UNDERSCORE, $answer_arr[$i]);//234_3
                        if($single_ans_arr[0] == $ques_id){
                            unset($answer_arr[$i]);  
                            $given_ans = $single_ans_arr[1];
                            $answer_arr = array_values($answer_arr); // re-index the array        
                            break;
                        }
                    }

                    $str_given_answer .= $ques_id."_".$given_ans.",";

                    $str_query = "SELECT title, answer_1, answer_2, answer_3, answer_4, right_answer FROM questionnaire WHERE id = ".$ques_id;
                    $query = $this->db->query($str_query);
                    $row = $query->row();
                    if (isset($row)) {
                        $title = $row->title;
                        $answer_1 = $row->answer_1;
                        $answer_2 = $row->answer_2;
                        $answer_3 = $row->answer_3;
                        $answer_4 = $row->answer_4;

                        $right_answer = $row->right_answer;

                        $is_given_ans_correct = false;
                        if($given_ans == 0){ //not answered the question
                            $not_answered += 1;
                        } else if($given_ans == $right_answer){// given answer is right
                            $is_given_ans_correct = true;
                            $correct_answer += 1;
                        } else if($given_ans != $right_answer){// given answer is wrong
                            $wrong_answer += 1;
                        }

                        if($right_answer == 1) {
                            $right_answer = $answer_1;
                        } else if($right_answer == 2) {
                            $right_answer = $answer_2;
                        } else if($right_answer == 3) {
                            $right_answer = $answer_3;
                        } else if($right_answer == 4) {
                            $right_answer = $answer_4;
                        }

                        if($given_ans == 1) {
                            $given_ans = $answer_1;
                        } else if($given_ans == 2) {
                            $given_ans = $answer_2;
                        } else if($given_ans == 3) {
                            $given_ans = $answer_3;
                        } else if($given_ans == 4) {
                            $given_ans = $answer_4;
                        } else {
                            $given_ans = "";
                        }

                        $counter++;
                        if($is_given_ans_correct) {
                            $evaluation_summary .= "<tr><td>".$counter."</td><td>".$title."</td><td>".$right_answer."</td><td style='color:#008000;'>".$given_ans."</td></tr>";
                        } else {
                            $evaluation_summary .= "<tr><td>".$counter."</td><td>".$title."</td><td>".$right_answer."</td><td style='color:#FF0000;'>".$given_ans."</td></tr>";
                        }
                    } 
                }

                $data["is_error"] = "false"; 
                $data["message"] = ""; 
                $data["evaluation_summary"] = $evaluation_summary;

                $exam_date = Date("Y-m-d H:i:s", now());

                $param = array(
                    'app_user_id' => $session_user_id,
                    'course_id' => $course_id,
                    'lesson_id' => $lesson_id,
                    'given_answer' => $str_given_answer,
                    'exam_date' => $exam_date
                );
                $this->db->insert('evaluation_report', $param);


                echo json_encode($data);
            }    
        }        
    }

    function report(){
        if(!isset($_SESSION)) { 
            session_start();
        } 
        
        $session_user_id = @$_SESSION["session_user_id"];
        if(is_null($session_user_id) || $session_user_id == "") {
            $this->load->view('login.php');
        } else {

            $evaluation_report_id = $_GET['id'];  

            $STR_QUERY = "SELECT id, app_user_id, given_answer, DATE_FORMAT(exam_date, '%d-%b-%Y') AS exam_date FROM evaluation_report WHERE id = ".$evaluation_report_id;

            $query = $this->db->query($STR_QUERY);
            $row = $query->row();
            if (isset($row)) {
                $app_user_id = $row->app_user_id;
                $str_given_answer = $row->given_answer;
            } 

            $evaluation_report = $given_ans = "";
            $counter = $correct_answer = $wrong_answer = $not_answered = 0;

            $given_answers_arr = explode(DELIM_COMA, $str_given_answer);//convert "," seperated string into array

            foreach($given_answers_arr as $given_answer){
                if($given_answer == "") continue;
                
                $answer_arr = explode(DELIM_UNDERSCORE, $given_answer);//234_3

                $ques_id = $answer_arr[0];
                $given_answer_id = $answer_arr[1];
                
                $str_query = "SELECT title, answer_1, answer_2, answer_3, answer_4, right_answer FROM questionnaire WHERE id = ".$ques_id;
                $query = $this->db->query($str_query);
                $row = $query->row();
                if (isset($row)) {
                    $title = $row->title;
                    $answer_1 = $row->answer_1;
                    $answer_2 = $row->answer_2;
                    $answer_3 = $row->answer_3;
                    $answer_4 = $row->answer_4;
                    $right_answer = $row->right_answer; 

                    $is_given_ans_correct = false;
                    if($given_answer_id == 0){ //not answered the question
                        $not_answered += 1;
                    } else if($given_answer_id == $right_answer){// given answer is right
                        $is_given_ans_correct = true;
                        $correct_answer += 1;
                    } else if($given_answer_id != $right_answer){// given answer is wrong
                        $wrong_answer += 1;
                    }

                    if($right_answer == 1) {
                        $right_answer = $answer_1;
                    } else if($right_answer == 2) {
                        $right_answer = $answer_2;
                    } else if($right_answer == 3) {
                        $right_answer = $answer_3;
                    } else if($right_answer == 4) {
                        $right_answer = $answer_4;
                    }

                    if($given_answer_id == 1) {
                        $given_ans = $answer_1;
                    } else if($given_answer_id == 2) {
                        $given_ans = $answer_2;
                    } else if($given_answer_id == 3) {
                        $given_ans = $answer_3;
                    } else if($given_answer_id == 4) {
                        $given_ans = $answer_4;
                    } else {
                        $given_ans = "";
                    }

                    $counter++;
                    if($is_given_ans_correct) {
                        $evaluation_report .= "<tr><td>".$counter."</td><td>".$title."</td><td>".$right_answer."</td><td style='color:#008000;'>".$given_ans."</td></tr>";
                    } else {
                        $evaluation_report .= "<tr><td>".$counter."</td><td>".$title."</td><td>".$right_answer."</td><td style='color:#FF0000;'>".$given_ans."</td></tr>";
                    }
                } 
            }

            $data["is_error"] = "false"; 
            $data["title"] = "Report"; 

            $data["evaluation_report"] = $evaluation_report;

            $this->load->view('model_test/report',$data);
        }        
    }

}