<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends CI_Model {
    
    var $table = 'course';

    function get_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('status',1);
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    private function _get_list_query(){       
        $this->db->select('id, name');
        $this->db->from('course');
        $this->db->where('status', 1); 

        if(trim($_POST['search']['value']) != '') {
            $where = "(name LIKE '%".$_POST['search']['value']."%')";
            $this->db->where($where);
        }
        $this->db->order_by("name", "ASC");
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
}