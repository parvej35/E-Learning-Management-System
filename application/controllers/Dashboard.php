<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){

		if(!isset($_SESSION)) { 
			session_start(); 
		}

        $user_id = @$_SESSION["session_user_id"];
        if(!isset($user_id) || $user_id == '') { 
            redirect(base_url());
        } else {
            $str_query = "SELECT er.id, l.name AS lesson_name, c.name AS course_name, DATE_FORMAT(er.exam_date, '%d-%b-%Y at %H:%i') AS exam_date
            FROM evaluation_report er 
            LEFT JOIN course c ON c.id = er.course_id 
            LEFT JOIN lesson l ON l.id = er.lesson_id 
            WHERE er.app_user_id = ".$user_id." ORDER BY er.exam_date";

            $result = $this->db->query($str_query);
            $data['evaluation_report'] = $result->result();

            $this->load->view('dashboard.php', $data);
        }
    }
}