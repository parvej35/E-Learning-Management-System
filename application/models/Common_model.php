<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_course_list(){
        $srt_query = "SELECT id, name FROM course WHERE status = 1 ORDER BY name ASC";
        $query = $this->db->query($srt_query);
        return $query->result();
    }

    function get_lesson_list(){
        $srt_query = "SELECT id, name FROM lesson WHERE status = 1 ORDER BY name ASC";
        $query = $this->db->query($srt_query);
        return $query->result();
    }
}