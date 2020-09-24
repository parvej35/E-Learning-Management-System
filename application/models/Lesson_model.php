<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson_model extends CI_Model {
    
    var $table = 'lesson';

    function get_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('status',1);
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    private function _get_list_query(){       
        $this->db->select('l.id, l.name AS lesson_name, c.name AS course_name');
        $this->db->from('lesson l');
        $this->db->join('course c', 'c.id = l.course_id', 'left');
        $this->db->where('l.status', 1); 

        if(trim($_POST['search']['value']) != '') {
            $where = "(l.name LIKE '%".$_POST['search']['value']."%' OR c.name LIKE '%".$_POST['search']['value']."%')";
            $this->db->where($where);
        }
        $this->db->order_by("l.name", "ASC");
    }

    function get_list() {
        $this->_get_list_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_list() {
        $this->_get_list_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $this->db->from($this->table);
        $this->db->where('status', 1);
        return $this->db->count_all_results();
    }

    function get_list_by_course_id($course_id){
        $srt_query = "SELECT id, name FROM lesson WHERE course_id = ".$course_id." AND status = 1 ORDER BY name ASC";
        $query = $this->db->query($srt_query);
        return $query->result();
    }
}