<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_item_type_role_model extends CI_Model
{
    function __construct() { 
        parent::__construct(); 
    } 
    public function save_item_type_role(){
        $data = array(

           "role_id"=> $this->input->post("role_name"),
           "item_type_id"=>$this->input->post("item_type_name")
        );
               
        if( $this->db->insert("item_type_role", $data)){
            return true;
         }
         else{
            return false;
         }
       
    }
    //get items from the db 
    public function get_roles() { 
        $this->db->where("deleted",0);
        return $result=$this->db->get("role");
        
    } 
    public function get_item_types() { 
        
        $this->db->where("deleted",0);
        return $result=$this->db->get("item_type");
                
    } 

}
