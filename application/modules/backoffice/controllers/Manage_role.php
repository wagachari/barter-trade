<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_role extends MX_Controller
{
    public $upload_path;
    public $upload_location;
    public  $per_page = 1000;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Manage_roles_model");
        $this->load->model("site/site_model");
        $this->upload_path=realpath(APPPATH."../assets/uploads");
        $this->upload_location=base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("file_model");
        
    }
    public function index(){
        $v_data = array(
            "all_roles" => $this->Manage_roles_model->get_role(),
             );

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/view_role", $v_data, true),
            
                    );
        $this->load->view("site/layouts/layout", $data);
                    
    }
   
    public function add_role(){
        
           //form validation
            $this->form_validation->set_rules("role_parent", 'role Parent', "required");   
            $this->form_validation->set_rules("role_name", 'role Name', "required");
            
            
            if ($this->form_validation->run()) {
               echo "hello";
                $resize = array(
                    "width" => 2000,
                    "height" => 2000
                )
                ;
                $upload_response  = $this->file_model->upload_image($this->upload_path, "role_image", $resize);
               
                if($upload_response['check'] == FALSE)
                {
                    $this->session->set_flashdata('error', $upload_response['message']);
                }
              
                else
                {
                    
                    if($this->Manage_roles_model->save_role($upload_response))
                    {
                        $this->session->set_flashdata('success', 'role Added successfully!!');
                        redirect("backoffice/Manage_role");
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'unable to add role. Try again!!');
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
                            "role"=>$this->Manage_roles_model->get_role(),
        );
    
            $data = array(
               
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("backoffice/add_role", $v_data, true),
            );
            $this->load->view("site/layouts/layout", $data);
            //
        
     }
     public function execute_search()
    {
        // Retrieve the posted search term.

        $search_term = $this->input->post('search');

        $v_data = array("results" => $this->Manage_roles_model->get_role($search_term));

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/execute_search", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);

    }

public function delete($role_id){
          
    $this->Manage_roles_model->delete($role_id);

    redirect("backoffice/Manage_role");
    
}
//deactivate
public function deactivate($id)
{
   
    $load_deactivate=$this->Manage_roles_model->deactivate_role($id);
    $v_data = array(
        "all_roles" =>  $load_deactivate,
        
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/view_role", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
    redirect("backoffice/Manage_role");
}
//activate
public function activate($id)
{
    $load_activate=$this->Manage_roles_model->activate_role($id);
    $v_data = array(
        "all_roles" =>  $load_activate,
        
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/view_role", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
    redirect("backoffice/Manage_role");
}
//edit update
public function edit_update($id){
    $this->form_validation->set_rules("role_parent", 'role Parent', "required");
    $this->form_validation->set_rules("role_name", 'role Name', "required");
    
    if ($this->form_validation->run()) {
       
        $resize = array(
            "width" => 2000,
            "height" => 2000
        )
        ;
        $upload_response  = $this->file_model->upload_image($this->upload_path, "role_image", $resize);
       
        if($upload_response['check'] == FALSE)
        {
            $this->session->set_flashdata('error', $upload_response['message']);
        }
      
        else
        {
            
            if($this->Manage_roles_model->edit_update_role($id,$upload_response))
            {
                $this->session->set_flashdata('success', 'role ,Added successfully!!');
                redirect("backoffice/Manage_role/");
            }
            else
            {
                $this->session->set_flashdata('error', 'unable to add role. Try again!!');
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
    
    $role = $this->Manage_roles_model->get_single($id);
    
    if($role->num_rows()>0)
    {
        $row=$role->row();
        $parent = $row->parent;
        $role_name = $row->role_name;
              
       
    }
    
    $v_data = array(
        
         "role"=>$this->Manage_roles_model->get_role(),
            
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/update_role", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
}
}