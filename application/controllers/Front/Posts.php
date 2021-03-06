<?php
class Posts extends CI_Controller
{
    
    public function index()
    {
    	$this->load->model('Front/Blog_model');
        $this->load->model('Front/Posts_model');
    	
    	$data['data_com']=$this->Blog_model->display_comments();

    	/* display posts*/
    	$data['data_services']=$this->Posts_model->display_services();
        $this->load->view('Front/common/header');
        $this->load->view('Front/services',$data);
        $this->load->view('Front/common/footer');
    }
     public function demandpost()     
    {
         $this->load->library('session');                 
         // $dum=$this->session->userdata['id'];
         // print_r($dum);die();
         if($this->session->userdata['id']){

          if(!empty($_FILES['file']['name'])){
          $config['upload_path'] = './uploads/demands_documents';
          $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc'; 
          $config['max_size'] = 6000000;
          $config['max_width'] = 45000;
          $config['max_height'] = 45000;

          $this->load->library('upload', $config);
  
          if (!$this->upload->do_upload('file')) 
          {
             $error = array('error' => $this->upload->display_errors());
             $image_name = '';
     
          } 
          else 
          {
            $img_data = $this->upload->data()['file_name'];
            $image_name = $img_data;
          }
        }
            // $this->load->library('session');
            //$session_id = $this->session->userdata('id');
            //print_r($session_id);die();

        if($image_name){
        $project_data = array(
            'mission_title' => $this->input->post('title'),
            'title' => $this->input->post('title'),
            'mission_budget' => $this->input->post('budget'),
            'budget' => $this->input->post('budget'),
            'description' => $this->input->post('description'),
            'mission_description' => $this->input->post('description'),
            'user_id' => $this->session->userdata['id'],
            'client_id' => $this->session->userdata['id'],
            'project_category' => $this->input->post('project_category'),
            'mission_category' => $this->input->post('project_category'),
            'mission_doc' => ($image_name)?$image_name:$this->input->post('file'),
            'file' => ($image_name)?$image_name:$this->input->post('file') 
        );          
        }
        else{
            $session_id= $_SESSION();
           // print_r( $session_id);die();
          $project_data = array(
           'mission_title' => $this->input->post('title'),
           'budget' => $this->input->post('budget'),
           'description' => $this->input->post('description'),
           'user_id' => $this->session->userdata['id'],
            'mission_category' => $this->input->post('project_category'),
         );           
        }
        $this->load->model('Front/Posts_model');
        $this->Posts_model->demand($project_data);
        redirect('Front/home/mydemands');
      }
      else{
        redirect(base_url() . 'Front/home/login'); 
      }

    }
 		 public function  offerpost() {
      if($this->session->userdata['id']){

 		 	if($this->input->post('accept_budget')==1){

 		 	$project_data = array(
            'message' => $this->input->post('message'),
            'project_id' => $this->input->post('project_id'),
            'user_id' => $this->session->userdata['id'],
            'client_id' => $this->input->post('client_id'),
            'accept_budget' => $this->input->post('accept_budget'),
            'offer_budget' => $this->input->post('missionbudget'),
            'created_date' => date('Y-m-d H:i:s')
 

        );
 		 }
 		 else{
 		 	$project_data = array(
            'message' => $this->input->post('message'),
            'project_id' => $this->input->post('project_id'),
            'user_id' => $this->session->userdata['id'],
            'client_id' => $this->input->post('client_id'),           
            'offer_budget' => $this->input->post('offer_budget'),
            'created_date' => date('Y-m-d H:i:s')

        );

 		 }

 		$this->load->model('Front/Posts_model');
        $this->Posts_model->mission($project_data);
        redirect('Front/home/mymissions');
      }
      else{
        redirect(base_url() . 'Front/home/login');  
      }

        }

        public function download($fileName)     
          {

           
            $this->load->helper('download');

            if ($fileName) {
          $file = base_url("/uploads/demands_documents/") .$fileName;
           //print_r($fileName);die();
          // check file exists    
          if ($file) {

           // get file content
           $data = file_get_contents ( $file );
           //force download
           force_download ( $fileName, $data );
          } else {
           // Redirect to base url
           redirect ( base_url ('Front/make_an_offer') );
          }
    
    }
  }




 public function  inprogress() {   

          if(!empty($_FILES['project_files']['name'])){
          $config['upload_path'] = './uploads/demands_documents';
          $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc'; 
          $config['max_size'] = 6000000;
          $config['max_width'] = 45000;
          $config['max_height'] = 45000;

          $this->load->library('upload', $config);
  
          if (!$this->upload->do_upload('project_files')) 
          {
             $error = array('error' => $this->upload->display_errors());
             $image_name = '';
     
          } 
          else 
          {
            $img_data = $this->upload->data()['file_name'];
            $image_name = $img_data;
          }
        }
           

        if($image_name){
        $project_data = array(
            'project_id' => $this->input->post('project_id'),
            'your_comments' => $this->input->post('your_comments'),
            'project_status' => $this->input->post('project_status'),
            'user_id' => $this->session->userdata['id'],
            'client_id' => $this->input->post('client_id'),            
            'project_files' => ($image_name)?$image_name:$this->input->post('project_files'),
            'date_created' => $this->input->post('date_created'),
            'date_updated' =>  date('Y-m-d H:i:s') 

        );          
        }
        else{
          
          $project_data = array(
           'project_id' => $this->input->post('project_id'),
           'budget' => $this->input->post('budget'),
           'description' => $this->input->post('description'),
           'user_id' => $this->session->userdata['id'],
          'client_id' => $this->input->post('client_id'),
          'date_created' => $this->input->post('date_created'),
          'date_updated' =>  date('Y-m-d H:i:s')
         );           
        }
        //print_r($project_data);die();
        $this->load->model('Front/Posts_model');
        $this->Posts_model->inprogress_mission($project_data);
        redirect('Front/home/mymissions');
 }

      public function delivered_mission(){
        $project_data = array(
            'project_id' => $this->input->post('project_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),            
            'date_modified' =>  date('Y-m-d H:i:s') 

        ); 
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_mission($project_data);
        redirect('Front/home/mymissions');

      }
      

      public function acceptoffer(){
        
        $this->load->view('Front/acceptoffer');


      } 


 public function delivered_demand(){
        $project_data = array(
            'project_id' => $this->input->post('project_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),            
            'date_modified' =>  date('Y-m-d H:i:s') 

        ); 
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_demand($project_data);
        redirect('Front/home/mydemands');

      }
      public function inprogress_demand(){
        $project_data = array(
            'project_id' => $this->input->post('project_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),            
            'date_modified' =>  date('Y-m-d H:i:s') 

        ); 
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_demand($project_data);
        redirect('Front/home/mydemands');

      }


     public function modify($mission_id){
     // print_r($mission_id);die();
       $this->load->library("session");

        $this->load->model('Front/Posts_model');
        $data= array('mission_status' => 1);
        $status = $this->Posts_model->deliver_askmodify($data,$mission_id);
        

        if($status){
       //echo $this->session->flashdata('Successfully','Project is in the progress ');
       redirect('Front/home/mydemands');
        }
      }
       public function complete_modify($mission_id){
     // print_r($mission_id);die();
       $this->load->library("session");

        $this->load->model('Front/Posts_model');
        $data= array('mission_status' => 1);
        $status = $this->Posts_model->deliver_askmodify($data,$mission_id);
        

        if($status){
       //echo $this->session->flashdata('Successfully','Project is in the progress ');
       redirect('Front/home/mydemands');
        }
      }
       public function delivered_pay_demand(){
        $date_created = date('Y-m-d H:i:s');
         $project_data = array(
           'mission_id' => $this->input->post('mission_id'),
           'mission_amount' => $this->input->post('mission_amount'),
           'amount_to_pay' => $this->input->post('amount_to_pay'),          
          'pay_status' => $this->input->post('pay_status'),
          'date_created' => $date_created,
          'mission_status' =>  $this->input->post('mission_status'),
          'employer_id' =>  $this->input->post('employer_id'),
          'date_of_pay' =>  date('Y-m-d H:i:s'),

         );  
         //print_r( $project_data);die();
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_paym_demand($project_data);
        redirect('Front/home/mydemands');
       }

       public function inprogress_pay_demand(){
         $project_data = array(
           'mission_id' => $this->input->post('mission_id'),
           'mission_amount' => $this->input->post('mission_amount'),
           'amount_to_pay' => $this->input->post('amount_to_pay'),          
          'pay_status' => $this->input->post('pay_status'),
          'date_created' => $this->input->post('date_created'),
          'mission_status' =>  $this->input->post('mission_status'),
          'employer_id' =>  $this->input->post('employer_id'),
          'date_of_pay' =>  date('Y-m-d H:i:s'),

         );  
         //print_r( $project_data);die();
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_paym_demand($project_data);
        redirect('Front/home/mydemands');
       }
       public function complete_pay_demand(){
         $project_data = array(
           'mission_id' => $this->input->post('mission_id'),
           'mission_amount' => $this->input->post('mission_amount'),
           'amount_to_pay' => $this->input->post('amount_to_pay'),          
          'pay_status' => $this->input->post('pay_status'),
          'date_created' => $this->input->post('date_created'),
          'mission_status' =>  $this->input->post('mission_status'),
          'employer_id' =>  $this->input->post('employer_id'),
          'date_of_pay' =>  date('Y-m-d H:i:s'),

         );  
         //print_r( $project_data);die();
        $this->load->model('Front/Posts_model');
        $this->Posts_model->deliver_paym_demand($project_data);
        redirect('Front/home/mydemands');
       }

       public function Notification(){
         $this->load->view('Front/common/header');
        $this->load->view('Front/notification');
         $this->load->view('Front/common/footer');  
       }


}
?>