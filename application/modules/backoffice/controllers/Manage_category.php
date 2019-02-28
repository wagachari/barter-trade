<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed'); 
class Manage_category extends MX_Controller
{
    public $upload_path;
    public $upload_location;
    public  $per_page = 1000;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Manage_category_model");
        $this->load->model("site/site_model");
        $this->upload_path=realpath(APPPATH."../assets/uploads");
        $this->upload_location=base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("file_model");
        
    }
    public function index(){
        $v_data = array(
            "all_categories" => $this->Manage_category_model->get_category(),
             );

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/view_category", $v_data, true),
            
                    );
        $this->load->view("site/layouts/layout", $data);
                    
    }
   
    public function add_category(){
        
           //form validation
            $this->form_validation->set_rules("category_parent", 'Category Parent', "required");   
            $this->form_validation->set_rules("category_name", 'Category Name', "required");
            
            
            if ($this->form_validation->run()) {
               echo "hello";
                $resize = array(
                    "width" => 2000,
                    "height" => 2000
                )
                ;
                $upload_response  = $this->file_model->upload_image($this->upload_path, "category_image", $resize);
               
                if($upload_response['check'] == FALSE)
                {
                    $this->session->set_flashdata('error', $upload_response['message']);
                }
              
                else
                {
                    
                    if($this->Manage_category_model->save_category($upload_response))
                    {
                        $this->session->set_flashdata('success', 'category Added successfully!!');
                        redirect("backoffice/Manage_category");
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'unable to add category. Try again!!');
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
                            "category"=>$this->Manage_category_model->get_category(),
        );
    
            $data = array(
               
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("backoffice/add_category", $v_data, true),
            );
            $this->load->view("site/layouts/layout", $data);
            //
        
     }
     public function execute_search()
    {
        // Retrieve the posted search term.

        $search_term = $this->input->post('search');

        $v_data = array("results" => $this->Manage_category_model->get_category($search_term));

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("backoffice/execute_search", $v_data, true),
        );
        $this->load->view("site/layouts/layout", $data);

    }
//more on crud
public function delete($category_id){
    // Check whether member id is not empty
    
        // Delete member
              
    $this->Manage_category_model->delete($category_id);

    redirect("backoffice/Manage_category");
    
}

public function deactivate($id)
{
   
    $load_deactivate=$this->Manage_category_model->deactivate_category($id);
    $v_data = array(
        "all_categories" =>  $load_deactivate,
        
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/view_category", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
    redirect("backoffice/Manage_category");
}
//activate
public function activate($id)
{
    $load_activate=$this->Manage_category_model->activate_category($id);
    $v_data = array(
        "all_categories" =>  $load_activate,
        
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/view_category", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
    redirect("backoffice/Manage_category");
}
public function edit_update($id){
    $this->form_validation->set_rules("category_parent", 'Category Parent', "required");
    $this->form_validation->set_rules("category_name", 'Category Name', "required");
    
    if ($this->form_validation->run()) {
       
        $resize = array(
            "width" => 2000,
            "height" => 2000
        )
        ;
        $upload_response  = $this->file_model->upload_image($this->upload_path, "category_image", $resize);
       
        if($upload_response['check'] == FALSE)
        {
            $this->session->set_flashdata('error', $upload_response['message']);
        }
      
        else
        {
            
            if($this->Manage_category_model->edit_update_category($id,$upload_response))
            {
                $this->session->set_flashdata('success', 'category ,Added successfully!!');
                redirect("backoffice/Manage_category/");
            }
            else
            {
                $this->session->set_flashdata('error', 'unable to add category. Try again!!');
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
    
    $category = $this->Manage_category_model->get_single($id);
    
    if($category->num_rows()>0)
    {
        $row=$category->row();
        $category_parent = $row->category_parent;
        $category_name = $row->category_name;
        $category_image = $row->category_image;
        
       
    }
    
    $v_data = array(
        
         "category"=>$this->Manage_category_model->get_category(),
            
    );

    $data = array(

        "title" => $this->site_model->display_page_title(),
        "content" => $this->load->view("backoffice/update_category", $v_data, true),
    );
    $this->load->view("site/layouts/layout", $data);
}
}