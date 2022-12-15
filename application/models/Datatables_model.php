<?php 

/**
 * 
 */
class Datatables_model extends CI_Model
{
	// function get_filtered_data($table){  
 //       // $this->make_query();  
 //       $query = $this->db->get();  
 //       return $query->num_rows();  
 //  	}       
    function get_all_data($table)  
    {  
       $this->db->select("*");  
       $this->db->from($table);  
       return $this->db->count_all_results();  
    }
}