<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_users extends MX_Controller
{
    public $upload_path;
    public $upload_location;
    public  $per_page = 1000;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Manage_users_model");
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
        
        $config["total_rows"] = $this->Manage_users_model->get_count();
        $config["base_url"] = base_url() . "backoffice/Manage_users/";
        $config["per_page"] = $per_page;
       //$config["total_rows"] = $this->Manage_users_model->get_user($config["per_page"], $page);

        $this->pagination->initialize($config);
        

        $v_data = array(
            "all_users" => $this->Manage_users_model->get_user($config["per_page"], $page),
            "page" => $page,
        );

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/view_user", $v_data, true),
            
                    );
        $this->load->view("site/layouts/layout", $data);
                    
        //

    }
    public function execute_search()
    {
        // Retrieve the posted search term.

        $search_term = $this->input->post('search');

        $v_data = array("results" => $this->Manage_users_model->get_results($search_term));

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/execute_search", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);

    }
    public function welcome($user_id)
    {
        $my_user = $this->Manage_users_model->get_single($user_id);
        //form validation
        if ($my_user->num_rows() > 0) {
            $row = $my_user->row();
            $first_name = $row->first_name;
            $last_name = $row->last_name;
            $phone_number = $row->phone_number;
            $username = $row->username;
            $user_email = $row->user_email;
            $password = $row->password;
            $location = $row->location;
            $profile_icon = $row->profile_icon;

            $validation_errors = '';

            $v_data = array(
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone_number" => $phone_number,
                "username" => $username,
                "user_email" => $user_email,
                "password" => $password,
                "location" => $location,
                "profile_icon" => $profile_icon,
                "validation_errors" => $validation_errors);

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("backoffice/welcome_here", $v_data, true),
            );

            $this->load->view("site/layouts/layout", $data);
        } else {

            $this->session->set_flashdata("error_message", "could not find the user with this id:" . $user_id );
            redirect('backoffice/Manage_users');
        }

    }
    public function new_user()
    {
        //form validation
        $this->form_validation->set_rules("first_name", 'First Name', "required");
        $this->form_validation->set_rules("last_name", 'Last Name', "required");    
        $this->form_validation->set_rules("phone_number", 'Phone Number', "required|numeric");    
        $this->form_validation->set_rules("username", 'Username', "required");
        $this->form_validation->set_rules("user_email", 'User Email', "required");
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
                
                if($this->Manage_users_model->add_user($upload_response))
                {
                    $this->session->set_flashdata('success', 'User Added successfully!!');
                    redirect("backoffice/Manage_users");
                }
                else
                {
                    $this->session->set_flashdata('error', 'unable to add user. Try again!!');
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
           
        $v_data = array("validation_errors" => validation_errors());

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/add_user", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        //
    }
    
    public function delete($user_id){
        // Check whether member id is not empty
        
            // Delete member
                  
        $this->Manage_users_model->delete($user_id);

        redirect("backoffice/Manage_users");
        
    }
    
    public function deactivate($id,$limit = NULL, $start = NULL)
    {
       $limit = $limit == NULL ? $this->per_page : $limit;
       $start = $start == NULL ? 1 : $start;
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $load_deactivate=$this->Manage_users_model->deactivate_user($id, $limit, $start);
        $v_data = array(
            "all_users" =>  $load_deactivate,
            "page"=>$page
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/view_user", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        redirect("backoffice/Manage_users");
    }
    //activate
    public function activate($id,$limit = NULL, $start = NULL)
    {
       $limit = $limit == NULL ? $this->per_page : $limit;
       $start = $start == NULL ? 1 : $start;
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $load_activate=$this->Manage_users_model->activate_user($id, $limit, $start);
        $v_data = array(
            "all_users" =>  $load_activate,
            "page"=>$page
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/view_user", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
        redirect("backoffice/Manage_users");
    }
    public function edit_update($id){
        $this->form_validation->set_rules("first_name", 'First Name', "required");
        $this->form_validation->set_rules("last_name", 'Last Name', "required");    
        $this->form_validation->set_rules("phone_number", 'Phone Number', "required|numeric");    
        $this->form_validation->set_rules("username", 'Username', "required");
        $this->form_validation->set_rules("user_email", 'User Email', "required");
        
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
                
                if($this->Manage_users_model->edit_update_user($id,$upload_response))
                {
                    $this->session->set_flashdata('success', 'User ,Added successfully!!');
                    redirect("backoffice/Manage_users");
                }
                else
                {
                    $this->session->set_flashdata('error', 'unable to add user. Try again!!');
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
        
        $users = $this->Manage_users_model->get_single($id);
        
        if($users->num_rows()>0)
        {
            $row=$users->row();
            $first_name = $row->first_name;
            $last_name = $row->last_name;
            $phone_number = $row->phone_number;
            $username = $row->username;
            $user_email = $row->user_email;
            $password = $row->password;
            //$location = $row->location;
            $profile_icon = $row->profile_icon;
            
           
        }
        
        $v_data = array(
            "first_name" =>$first_name,     
            "last_name" => $last_name,
            "phone_number" => $phone_number,
            "username" => $username,
            "user_email" => $user_email,
            "password" => $password,
            //"location" => $location,
            "profile_icon" => $profile_icon,
                
        );

        $data = array(

            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/update_users", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);
    }
}

