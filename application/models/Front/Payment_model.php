<?php
class Payment_model extends CI_Model
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
        return $this->db->count_all('mission');
    }

    function display_alldemand($limit,$start)
    {
        $id =$this->session->userdata['id'];
        //$query = $this->db->query("select * from mission  order by mission_id");
        $this->db->select('*');
        $this->db->from('mission');
        $this->db->where('user_id != ',$id);
        $this->db->order_by('mission_id');
        $this->db->limit($limit,$start);
        //print_r();die();
        $query=$this->db->get()->result_array();
        return $query;

    }

    public function demand($project_data){

        $this->db->insert('mission',$project_data);
        
        return true;
    }
    public function mission($project_data){

        $this->db->insert('Project_offer',$project_data);
        
        return true;
    }
     public function mymission($status){

        $this->db->select('Project_offer.*,mission.*,users.username');
        $this->db->from('Project_offer');        
        $this->db->join('mission','mission.mission_id = Project_offer.project_id');
        $this->db->join('users','users.id = Project_offer.client_id');
         $this->db->where('Project_offer.user_id',$this->session->userdata['id']);
         $this->db->where('mission.mission_status',$status);
       
        $result= $this->db->get()->result_array();
        //print_r($this->db->last_query());die();


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

         $this->db->select('*');
        $this->db->from('mission'); 
         $this->db->where('user_id',$this->session->userdata['id']);
         $this->db->where('mission_status',$status);
        $result= $this->db->get()->result_array();
        //print_r($this->db->last_query());die();


        // $this->db->insert('Project_offer',$project_data);
        
        return $result;
    }
    public function get_username($project){

             $this->db->select('username');
            $this->db->from('users'); 
            $this->db->where('id',$project);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }

        public function acceptOfferafter($mission_id)
    {
      //$update_data = array('status'=>1,'accept_status'=>1);
       $update_data1 = array('mission_status'=>1);
     // $this->db->where($con);
     // $this->db->update($this->project_offer_table_name,$update_data);
  

  $this->db->where('mission_id',$mission_id);

      $this->db->update('mission',$update_data1);


      if($this->db->affected_rows() > 0)
      {
        return true;
      }
      else 
      {
        return false;
      }
        

    }

        public function get_mission_name($project){

             $this->db->select('mission_title');
            $this->db->from('mission'); 
            $this->db->where('mission_id',$project);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }
    public function demand_posted($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.client_id');
             $this->db->where('project_id',$project);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }

public function get_offer_amount($project){

             $this->db->select('Project_offer.offer_budget,Project_offer.user_id,Project_offer.project_id');
            $this->db->from('Project_offer'); 
            $this->db->where('offer_id',$project);
            $result= $this->db->get()->result_array();           
            
            return $result;
        }

         public function demand_posted2($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.client_id');
             $this->db->where('project_id',$project);
             $this->db->order_by("offer_budget", "DESC");
            $result= $this->db->get()->result_array();           
            
            return $result;
        }
         public function demand_posted3($project){

             $this->db->select('Project_offer.*,users.username,users.picture_url');
            $this->db->from('Project_offer'); 
            // $this->db->where('client_id',$this->session->userdata['id']);
             $this->db->join('users','users.id = Project_offer.client_id');
             $this->db->where('project_id',$project);
             $this->db->where('accept_status', 0);
             $this->db->order_by("created_date", "DESC");
            $result= $this->db->get()->result_array();           
            
            return $result;
        }

public function getPaymentIn($user_id)
    {
      $this->db->select("transaction.*");
      $this->db->from('transaction');

      $this->db->where('transaction.sent_to',$user_id);
      $this->db->order_by('transaction.id', 'DESC');
      $data = $this->db->get()->result();
      foreach ($data as $value) {

      $sent_from = $value->sent_from;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_from);
      $data_sent_from = $this->db->get()->result();
      $sent_from_username = $data_sent_from[0]->username;

      $sent_to = $value->sent_to;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_to);
      $data_sent_to = $this->db->get()->result();
      $sent_to_username = $data_sent_to[0]->username;


      $mission_id = $value->mission_id;
      $this->db->select("mission_title");
      $this->db->from('mission');
      $this->db->where('mission_id',$mission_id);
      $mission_title = $this->db->get()->result();
      $mission_title1 = $mission_title[0]->mission_title;

      $student_one[] = array("id"=>$value->id, "sent_from"=>$value->sent_from,   
                  "sent_to"=>$value->sent_to, "amount"=>$value->amount,   
                  "tra_id"=>$value->tra_id, "created_date"=>$value->created_date, "username"=>$value->username, "project_title"=>$mission_title1, "sent_from_username"=>$sent_from_username, "sent_to_username"=>$sent_to_username);


      }

      return $student_one;

    }
public function getPayment($user_id)
    {
      $this->db->select("transaction.*");
      $this->db->from('transaction');

      $this->db->where('transaction.sent_to',$user_id);
      $this->db->or_where('transaction.sent_from',$user_id);

      $this->db->order_by('transaction.id', 'DESC');
      $data = $this->db->get()->result();
      foreach ($data as $value) {

      $sent_from = $value->sent_from;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_from);
      $data_sent_from = $this->db->get()->result();
      $sent_from_username = $data_sent_from[0]->username;

      $sent_to = $value->sent_to;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_to);
      $data_sent_to = $this->db->get()->result();
      $sent_to_username = $data_sent_to[0]->username;


      $mission_id = $value->mission_id;
      $this->db->select("mission_title");
      $this->db->from('mission');
      $this->db->where('mission_id',$mission_id);
      $mission_title = $this->db->get()->result();
      $mission_title1 = $mission_title[0]->mission_title;

      $student_one[] = array("id"=>$value->id, "sent_from"=>$value->sent_from,   
                  "sent_to"=>$value->sent_to, "amount"=>$value->amount,   
                  "tra_id"=>$value->tra_id, "created_date"=>$value->created_date, "username"=>$value->username, "project_title"=>$mission_title1, "sent_from_username"=>$sent_from_username, "sent_to_username"=>$sent_to_username);


      }

      return $student_one;

    }

    public function getallnotificationcount($user_id,$type_id)
    {
        $this->db->select("notification.*");
        $this->db->from('notification');
       // $this->db->join("$this->user_table_name","$this->demand_table_name.client_id = $this->user_table_name.id");
        $this->db->where('user_id',$user_id);

$this->db->where('type_id',$type_id);
$this->db->where('read_status',0);
        $data = $this->db->get()->result();
       /*        echo $str = $this->db->last_query();
        exit();*/
        return $data;
    }

    public function getPaymentOut($user_id)
    {
/*      $this->db->select("*");
      $this->db->from('transaction');
      $this->db->where('sent_from',$user_id);
      $data = $this->db->get()->result();
      foreach ($data as $value) {*/

      $this->db->select("transaction.*");
      $this->db->from('transaction');
      $this->db->join('mission','transaction.mission_id = mission.mission_id');
      $this->db->where('transaction.sent_from',$user_id);
      $this->db->where('mission.mission_status',3);  
      $this->db->order_by('transaction.id', 'DESC'); 
      $data = $this->db->get()->result();
/*      echo $str = $this->db->last_query();
exit();*/
      foreach ($data as $value) {

      $sent_from = $value->sent_from;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_from);
      $data_sent_from = $this->db->get()->result();
      $sent_from_username = $data_sent_from[0]->username;

      $sent_to = $value->sent_to;
      $this->db->select("username");
      $this->db->from('users');
      $this->db->where('id',$sent_to);
      $data_sent_to = $this->db->get()->result();
      $sent_to_username = $data_sent_to[0]->username;

      $mission_id = $value->mission_id;
      $this->db->select("mission_title");
      $this->db->from('mission');
      $this->db->where('mission_id',$mission_id);
      $mission_title = $this->db->get()->result();
      $mission_title1 = $mission_title[0]->mission_title;

      $student_one[] = array("id"=>$value->id, "sent_from"=>$value->sent_from,   
                  "sent_to"=>$value->sent_to, "amount"=>$value->amount,   
                  "tra_id"=>$value->tra_id, "created_date"=>$value->created_date, "username"=>$value->username, "project_title"=>$mission_title1, "sent_from_username"=>$sent_from_username, "sent_to_username"=>$sent_to_username);


      }
      return $student_one;

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

   public function delete_card_details($id){
        $this->db->where('id',$id);
      $activity =  $this->db->delete('card_details');
 return $activity;
      }

      public function add_card_details($app)

  {

     if(!empty($app))

      {

        $this->db->insert('card_details',$app);
$insert_id = $this->db->insert_id();

       $this->db->select("*");
      $this->db->from('card_details');
      $this->db->where('id',$insert_id);
      $data = $this->db->get()->result();
      return $data;

       //return true;

      }

  }

  public function update_card_details($card_id,$data)
    {
    
  

      $this->db->where('id',$card_id);

      $this->db->update('card_details',$data);
 


      if($this->db->affected_rows() > 0)
      {

        return true;
      }
      else 
      {
        return false;
      }
        

    }

   public function get_card_details($id)
    {
      $this->db->select("*");
      $this->db->from('card_details');
      $this->db->where('user_id',$id);
      $data = $this->db->get()->result();
      return $data;

    }
public function inserransection($data)
    {
        $this->db->insert('transaction',$data);
        $response['status'] = true;
        $response['message'] = 'Inserted Successfully';
        return $response;
    }
}
?>
