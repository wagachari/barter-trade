<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_items_model extends CI_Model
{
    protected $table = "item";
    //public function add_item($item_image)
    public function add_item($upload_response)
    {
        $file_name = $upload_response['file_name'];
        $thumb_name = $upload_response['thumb_name'];
        $data = array(
            "item_name" => $this->input->post("item_name"),
            "item_description" => $this->input->post("item_description"),
            "item_cost" => $this->input->post("item_cost"),
            //TODO make the user ID dynamic
            "user_id" => 1,
            "category_id" => $this->input->post("category_name"),
            //"item_image_name"=> $file_name,
            //"profile_thumb"=> $thumb_name,
            "deleted"=>0
        );

        
        if( $this->db->insert("item", $data)){
           return true;
        }
        else{
           return false;
        }
    }
   public function add_desired_item(){
    $data = array(
        array(
        "desired_item_name" => $this->input->post("item1"),
        "category_id" => $this->input->post("category_name"),
        "user_id" => 1,
        "deleted"=>0
    ),
    array(
        "desired_item_name" => $this->input->post("item2"),
        "category_id" => $this->input->post("category_name"),
        "user_id" => 1,
        "deleted"=>0
    ),
    array(
        "desired_item_name" => $this->input->post("item3"),
        "category_id" => $this->input->post("category_name"),
        "user_id" => 1,
        "deleted"=>0
    )
    );

    
    if( $this->db->insert_batch("desired_item", $data)){
       return true;
    }
    else{
       return false;
    }
   }
    public function get_item($limit, $start)
    {
        $this->db->where("deleted",0);
        $this->db->order_by("created_on", "DESC");
        $this->db->limit($limit, $start);
        return $this->db->get('item');
    }
    //get categories
    public function get_all_categories() { 
        $this->db->select("*");
        $this->db->from("category");
        $this->db->where("deleted",0);
       
        return $result=$this->db->get();

        
    } 


    public function get_all_items()
    {
        $this->db->where("deleted",0);
        $this->db->order_by("created_on", "DESC");

        return $this->db->get('item');
    }
    public function get_single($item_id)
    {
        $this->db->where("item_id", $item_id);
        return $this->db->get("item");
    }
    public function get_results($search_term = 'default')
    {
// Use the Active Record class for safer queries.
        $this->db->select('*');
        $this->db->where("deleted",0);
        $this->db->from('item');
        $this->db->like('first_name', $search_term);

// Execute the query.
        $query = $this->db->get();

// Return the results.
        return $query->result_array();
    }
//pagination
    public function get_count()
    {
        return $this->db->count_all($this->table);
    }
    //delete
    public function delete($id){
        // Delete member data
        $this->db->set("deleted", 1,"modified_on",date("Y-m-d H:i:s"),"deleted_on",date("Y-m-d H:i:s"));
        $this->db->where("item_id",$id);
       
        if($this->db->update("item"))
        {
            $this->session->set_flashdata("success","You have deleted".$id);
            return TRUE;
        }
        else
        {
            $this->session->set_flashdata("error","Unable to delete".$id);
            return FALSE;
        }
        
    }
    public function deactivate_item($id, $limit,$start)
    {
        
        $this->db->where("item_id",$id);
       $this->db->set("item_status",0);
       if($this->db->update("item"))
       {
            $remain=$this->get_item($limit, $start);
            $this->session->set_flashdata("success","You have deactivated".$id);
            return $remain;
       }
       else 
       {
        $this->session->set_flashdata("error","Unable to deactivate".$id);
        return FALSE;
       }
    }
    //activate
    public function activate_item($id, $limit,$start)
    {
        
        $this->db->where("item_id",$id);
       $this->db->set("item_status",1);
       if($this->db->update("item"))
       {
            $remain=$this->get_item($limit, $start);
            $this->session->set_flashdata("success","You have activated".$id);
            return $remain;
       }
       else 
       {
        $this->session->set_flashdata("error","Unable to activate".$id);
        return FALSE;
       }
    }
    public function edit_update_item($id,$upload_response)
    {
        $file_name = $upload_response['file_name'];
        $thumb_name = $upload_response['thumb_name'];
        $this->db->where("item_id",$id);
        $this->db->get("item");
        //Capture data to be updated
        $data = array(
            "first_name" => $this->input->post("first_name"),
            "last_name" => $this->input->post("last_name"),
            "phone_number" => $this->input->post("phone_number"),
            "itemname" => $this->input->post("itemname"),
            "item_email" => $this->input->post("item_email"),
            "profile_icon"=> $file_name,
            "profile_thumb"=> $thumb_name,
            "deleted"=>0,
            "modified_on"=>date("Y-m-d H:i:s")
        );
         
        if( $this->db->update("item", $data)){
            return true;
         }
         else{
            return false;
         }
    }

}
