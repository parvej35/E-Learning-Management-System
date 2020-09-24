<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questionnaire_model extends CI_Model {
    
    var $table = 'questionnaire';

    function get_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('status',1);
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    private function _get_list_query(){       
        $this->db->select('q.id, q.title, q.answer_1, q.answer_2, q.answer_3, q.answer_4, q.right_answer, q.status, q.course_id AS course_id, c.name as course_name, q.lesson_id AS lesson_id, l.name as lesson_name');
        $this->db->from('questionnaire q');
        $this->db->join('course c', 'c.id = q.course_id', 'left');
        $this->db->join('lesson l', 'l.id = q.lesson_id', 'left');
        $this->db->where('q.status', 1);

        if(trim($_POST['search']['value']) != '') {
            $value = trim($_POST['search']['value']);
            $where = "(q.title LIKE '%".$value."%' OR q.answer_1 LIKE '%".$value."%' OR q.answer_2 LIKE '%".$value."%' OR q.answer_3 LIKE '%".$value."%' OR q.answer_4 LIKE '%".$value."%' OR c.name LIKE '%".$value."%' OR l.name LIKE '%".$value."%')";
            $this->db->where($where);
        }
        $this->db->order_by("q.id", "desc");
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