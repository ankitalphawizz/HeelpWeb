<?php
class Posts_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function auth_check($data_services)
    {
        $query = $this->db->get_where('posts', $data_services);
        if ($query)
        {
            return $query->row();
        }
        return false;
    }
   

    // Display Services
    function display_services()
    {
        $query = $this->db->query("select * from project_category  order by project_id");

        return $query->result();

    }
     public function get_count() {
         //$this->db->where('mission_id',$id);
        //$cat = 

        return $this->db->count_all('mission');
    }
     public function get_cat_count($id) {
         $this->db->where('mission_category',$id);
        //$cat = 

        return $this->db->count_all('mission');
    }
    
     public function display_cate_data($limit,$start,$cat_id)
    {
        $id =$this->session->userdata['id'];
        //$query = $this->db->query("select * from mission  order by mission_id");
        $this->db->select('*');
        $this->db->from('mission');
        $this->db->where('user_id != ',$id);
         $this->db->where('mission_category',$cat_id);
        $this->db->order_by('mission_id');
        $this->db->limit($limit,$start);
        //print_r();die();
        $query=$this->db->get()->result_array();
        return $query;

    }

    function display_alldemand($cat_id,$limit,$start)
    {
        $id =$this->session->userdata['id'];
        //$query = $this->db->query("select * from mission  order by mission_id");
        $this->db->select('*');
        $this->db->from('mission');
        $this->db->where('client_id != ',$id);
        $this->db->where('accepted_by = ', 0);
        if($cat_id)
        {
        $this->db->where('mission_category', $cat_id);
    }
        $this->db->order_by('mission_id');
        $this->db->limit($limit,$start);
        //print_r();die();
        $query=$this->db->get()->result_array();
        return $query;

    }

    function count_display_alldemand($cat_id)
    {
        $id =$this->session->userdata['id'];
        //$query = $this->db->query("select * from mission  order by mission_id");
        $this->db->select('*');
        $this->db->from('mission');
        $this->db->where('client_id != ',$id);
        $this->db->where('accepted_by = ', 0);
        if($cat_id)
        {
        $this->db->where('mission_category', $cat_id);
    }
        $this->db->order_by('mission_id');
        
        //print_r();die();
        $query=$this->db->get()->result_array();
        return count($query);

    }

    public function demand($project_data){

        $this->db->insert('mission',$project_data);
        
        return true;
    }
    public function mission($project_data){

        $this->db->insert('Project_offer',$project_data);
        
        return true;
    }
    public function fetchofferedmission($user_id)
    {
      $this->db->select("project_id");
      $this->db->from('Project_offer');
      $this->db->where('user_id',$user_id);
      $offered_id_array = $this->db->get()->result();
      //echo ($this->db->last_query());die();
      foreach ($offered_id_array as $value) {
     $test_offer[] = $value->project_id;

      }

      //$offer_ids = implode(",", $test_offer);
      
      return $test_offer;
      
    }
     public function mymission($myofferedmission){

        $this->db->select('mission.*,users.username');
        $this->db->from('mission');        
        ///$this->db->join('Project_offer','Project_offer.project_id = mission.mission_id');
        //$this->db->join('users','users.id = Project_offer.client_id');
        $this->db->join('users','users.id = mission.client_id');
         //$this->db->where('Project_offer.user_id',$this->session->userdata['id']);
         //$this->db->where('mission.mission_status',$status);
       $this->db->where_in('mission.mission_id',$myofferedmission);
       $this->db->order_by("mission_id","Desc");
        $result= $this->db->get()->result_array();
        //echo ($this->db->last_query());die();

        


        // $this->db->insert('Project_offer',$project_data);
        
        return $result;
    }

    function display_cat()
    {
        $query = $this->db->query("select * from project_category  order by project_id");

        return $query->result_array();

    }

    
     public function inprogress_mission($project_data){

        $update = $this->db->insert('project_status',$project_data);
        if($update){
            $this->db->update('project_status',2);
        }
        else{

        }
        
        return true;
    }
   public function deliver_mission(){
    $this->db->insert('litigations',$project_data);
        
        return true;
   }

    public function mydemand($status){

         $this->db->select('mission.*,users.username');
        $this->db->from('mission'); 
        $this->db->join('users','users.id = mission.client_id');
         $this->db->where('client_id',$this->session->userdata['id']);
         //$this->db->where('mission_status',$status);
         $this->db->order_by("mission_id","Desc");
        $result= $this->db->get()->result_array();
        //print_r($this->db->last_query());die();


        // $this->db->insert('Project_offer',$project_data);
        
        return $result;
    }
    public function demand_posted($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.user_id');
             $this->db->where('Project_offer.project_id',$project);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }

        public function mission_posted($project,$user_id){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.user_id');
             $this->db->where('Project_offer.project_id',$project);
             $this->db->where('Project_offer.user_id',$user_id);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }
         public function demand_posted2($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.user_id');
             $this->db->where('Project_offer.project_id',$project);
             $this->db->order_by("Project_offer.offer_budget", "DESC");
            $result= $this->db->get()->result_array();           
            
            return $result;
        }
         public function demand_posted3($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.user_id');
             $this->db->where('Project_offer.project_id',$project);
            
             $this->db->order_by("Project_offer.created_date", "DESC");
            $result= $this->db->get()->result_array();           
            // /echo ($this->db->last_query());die();
            return $result;
        }


        public function offeraccept($user_id){
            $data= array('accept_status' => 2);
            $this->db->set($data);
            $this->db->where('user_id', $user_id);
            $status = $this->db->update('Project_offer');
            if($status){
                    $data= array('mission_status' => 1);
                    $this->db->set($data);
                    $this->db->where('user_id', $user_id); 
                    $this->db->update('mission');
                     return true ;

            }
            else{
                 return false ;
            }           

        }
         public function deliver_demand(){
            $this->db->insert('litigations',$project_data);
        
            return true;
          }

         public function deliver_askmodify($data,$mission_id){
            //print_r($mission_id);die();

            $this->db->set($data);
            $this->db->where('mission_id', $mission_id);
            $status = $this->db->update('mission');
            
             return true ;

             }
             public function deliver_paym_demand ($project_data){
                $status = $this->db->insert('withdrawpayment',$project_data);

                if($status){
                    $this->db->set('mission_status', 3);
                    $this->db->where('mission_id', $project_data['mission_id']);
                    $status = $this->db->update('mission');
                return true ;
             }
             else {
                return false ;  
             }
         }
         public function inprogress_pay_demand ($project_data){
                $status = $this->db->insert('withdrawpayment',$project_data);

                if($status){
                    $this->db->set('mission_status', 2);
                    $this->db->where('mission_id', $project_data['mission_id']);
                    $status = $this->db->update('mission');
                return true ;
             }
             else {
                return false ;  
             }
         }

 public function selectAvgOfRating($user_id)
 {
   $this->db->select("rating");
   $this->db->from('user_review');
   $this->db->where('to_user_id',$user_id);
   $data = $this->db->get();

   //$count = $data->num_rows();
   $data = $data->result();
   return $data;
 } 

public function GetNotification($type_id){
    $this->db->select('*');
    $this->db->from('notification');
    $this->db->where('user_id',$this->session->userdata['id']);
    $this->db->where('type_id',$type_id);
    $result = $this->db->get()->result_array();

    return $result ;
 }
}
?>
