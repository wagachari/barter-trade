<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_items extends MX_Controller
{
    public $upload_path;
    public $upload_location;
    public  $per_page = 1000;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Manage_items_model");
        $this->load->model("site/site_model");
        $this->load->library('pagination');
        $this->upload_path=realpath(APPPATH."../assets/uploads");
        $this->upload_location=base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("file_model");

    }

    public function index()
    {
        //Pagination
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $per_page = 1000;
        $config = array();
        
        $config["total_rows"] = $this->Manage_items_model->get_count();
        $config["base_url"] = base_url() . "trader/Manage_items/";
        $config["per_page"] = $per_page;
       //$config["total_rows"] = $this->Manage_items_model->get_item($config["per_page"], $page);

        $this->pagination->initialize($config);
        

        $v_data = array(
            "all_items" => $this->Manage_items_model->get_item($config["per_page"], $page),
            "page" => $page,
        );

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/view_item", $v_data, true),
            
                    );
        $this->load->view("site/layouts/layout", $data);
                    
        //

    }
    public function execute_search()
    {
        // Retrieve the posted search term.

        $search_term = $this->input->post('search');

        $v_data = array("results" => $this->Manage_items_model->get_results($search_term));

        $data = array(
           
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/execute_search", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);

    }
    public function welcome($item_id)
    {
        $my_item = $this->Manage_items_model->get_single($item_id);
        //form validation
        if ($my_item->num_rows() > 0) {
            $row = $my_item->row();
            $first_name = $row->first_name;
            $last_name = $row->last_name;
            $phone_number = $row->phone_number;
            $itemname = $row->itemname;
            $item_email = $row->item_email;
            $password = $row->password;
            $location = $row->location;
            $profile_icon = $row->profile_icon;

            $validation_errors = '';

            $v_data = array(
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone_number" => $phone_number,
                "itemname" => $itemname,
                "item_email" => $item_email,
                "password" => $password,
                "location" => $location,
                "profile_icon" => $profile_icon,
                "validation_errors" => $validation_errors);

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("trader/welcome_here", $v_data, true),
            );

            $this->load->view("site/layouts/layout", $data);
        } else {

            $this->session->set_flashdata("error_message", "could not find the item with this id:" . $item_id );
            redirect('trader/Manage_items');
        }

    }
    public function new_item()
    {
        //form validation
        $this->form_validation->set_rules("item_name", 'First Name', "required");
        $this->form_validation->set_rules("last_name", 'Last Name', "required");    
        $this->form_validation->set_rules("phone_number", 'Phone Number', "required|numeric");    
        $this->form_validation->set_rules("itemname", 'itemname', "required");
        $this->form_validation->set_rules("item_email", 'item Email', "required");
        $this->form_validation->set_rules("password", 'Password', "required");
        // $this->form_validation->set_rules("location", 'location', "required");
        
        // $validation_errors = '';
        // $this->load->library('image_lib');
        if ($this->form_validation->run()) {
           
            $resize = array(
                "width" => 2000,
                "height" => 2000
            )
            ;
            $upload_response  = $this->file_model->upload_image($this->upload_path, "profile_icon", $resize);
           
            if($upload_response['check'] == FALSE)
            {
                $this->session->set_flashdata('error', $upload_response['message']);
            }
          
            else
            {
                
                if($this->Manage_items_model->add_item($upload_response))
                {
                    $this->session->set_flashdata('success', 'item Added successfully!!');
                    redirect("trader/Manage_items");
                }
                else
                {
                    $this->session->set_flashdata('error', 'unable to add item. Try again!!');
                }
            }
            
        }
        else 
        {
           if(!empty(validation_errors())) 
           {
                $this->session->set_flashdata('error', validation_errors());
           }
        }
           
        $v_data = array("validation_errors" => validation_errors(),
        "categories" => $this->Manage_items_model->get_all_categories(),
    
    );

        $data = array(
           
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/add_item", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        //
    }
    
    public function delete($item_id){
        // Check whether member id is not empty
        
            // Delete member
                  
        $this->Manage_items_model->delete($item_id);

        redirect("trader/Manage_items");
        
    }
    
    public function deactivate($id,$limit = NULL, $start = NULL)
    {
       $limit = $limit == NULL ? $this->per_page : $limit;
       $start = $start == NULL ? 1 : $start;
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $load_deactivate=$this->Manage_items_model->deactivate_item($id, $limit, $start);
        $v_data = array(
            "all_items" =>  $load_deactivate,
            "page"=>$page
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/view_item", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        redirect("trader/Manage_items");
    }
    //activate
    public function activate($id,$limit = NULL, $start = NULL)
    {
       $limit = $limit == NULL ? $this->per_page : $limit;
       $start = $start == NULL ? 1 : $start;
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $load_activate=$this->Manage_items_model->activate_item($id, $limit, $start);
        $v_data = array(
            "all_items" =>  $load_activate,
            "page"=>$page
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/view_item", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        redirect("trader/Manage_items");
    }
    public function edit_update($id){
        $this->form_validation->set_rules("first_name", 'First Name', "required");
        $this->form_validation->set_rules("last_name", 'Last Name', "required");    
        $this->form_validation->set_rules("phone_number", 'Phone Number', "required|numeric");    
        $this->form_validation->set_rules("itemname", 'itemname', "required");
        $this->form_validation->set_rules("item_email", 'item Email', "required");
        
        // $this->form_validation->set_rules("location", 'location', "required");
        
        // $validation_errors = '';
        // $this->load->library('image_lib');
        if ($this->form_validation->run()) {
           
            $resize = array(
                "width" => 2000,
                "height" => 2000
            )
            ;
            $upload_response  = $this->file_model->upload_image($this->upload_path, "profile_icon", $resize);
           
            if($upload_response['check'] == FALSE)
            {
                $this->session->set_flashdata('error', $upload_response['message']);
            }
          
            else
            {
                
                if($this->Manage_items_model->edit_update_item($id,$upload_response))
                {
                    $this->session->set_flashdata('success', 'item ,Added successfully!!');
                    redirect("trader/Manage_items");
                }
                else
                {
                    $this->session->set_flashdata('error', 'unable to add item. Try again!!');
                }
            }
            
        }
        else 
        {
           if(!empty(validation_errors())) 
           {
                $this->session->set_flashdata('error', validation_errors());
           }
        }
        
        $items = $this->Manage_items_model->get_single($id);
        
        if($items->num_rows()>0)
        {
            $row=$items->row();
            $first_name = $row->first_name;
            $last_name = $row->last_name;
            $phone_number = $row->phone_number;
            $itemname = $row->itemname;
            $item_email = $row->item_email;
            $password = $row->password;
            //$location = $row->location;
            $profile_icon = $row->profile_icon;
            
           
        }
        
        $v_data = array(
            "first_name" =>$first_name,     
            "last_name" => $last_name,
            "phone_number" => $phone_number,
            "itemname" => $itemname,
            "item_email" => $item_email,
            "password" => $password,
            //"location" => $location,
            "profile_icon" => $profile_icon,
                
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("trader/update_items", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
    }
}
