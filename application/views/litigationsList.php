
    <style>
  .modal-content {
    width: 625px;
    height: 600px;
    margin-top: 114px;
}
div#dtBasicExample_length {
    margin-left: 19px;
}
</style>
  
</style>
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
          <div class="card-header card-header-primary">
          <h3><?= ('Litigations List') ?></h3>
          <p class="card-category"><?= ('Here is a subtitle for this table')?></p>
          </div>
          <form method="post" action="<?php echo base_url('table/export_csv')?>">
            <div class="from_to_date_picker">             
              <ul>
                <li><label>From Date:</label> <input type="text" name="from_date" id="from_date" value="" required=""></li>
                <li><label>To Date:</label> <input type="text" name="to_date" id="to_date" value="" required=""> </li>
                <li><input type="submit" name="export" class="export_btn" id="export" value="Export"></li>
              </ul>
            </div>
          </form>
        <script type="text/javascript">
            $(function () {
                $('#from_date').datetimepicker({
                 format: 'DD/MM/YYYY'
           });
            });
             $(function () {
                $('#to_date').datetimepicker({
                 format: 'DD/MM/YYYY'
           });
            });
        </script>
            <div class="card-body">
              <div class="table-responsive">
                <table id="dtBasicExample" class="table table-striped  table-sm" cellspacing="0" width="100%">
                  <thead class=" text-primary">
                    <th><?=('Date of litigation')?></th> 
                    <th><?=('Project id')?></th>
                    <th><?=('User who open litigation')?></th>
                    <th><?=('Title')?></th>
                    <th><?=('Description of litigation')?></th> 
                    <th><?=('Comment')?></th>
                    <th><?=('Action')?></th> 
                  </thead>
                  
                  <tbody>


                    <?php  foreach($litigationslist as $user){

                      $newDate = date("dmy", strtotime($user->date_created));

                      $invID = str_pad($user->project_id, 5, '0', STR_PAD_LEFT);


                      ?>

                  <tr>
                  <td ><?php echo date("d-m-Y", strtotime($user->date_created)); ?> </td>
                  <!-- <td><?php echo $user->project_id;?> </td> -->
                  <td> <?php echo $newDate . $invID ;?> </td>
                  <td> <?php echo $user->user_email;?> </td>
                  <td> <?php echo $user->title;?> </td>
                  <td> <?php echo $user->description;?> </td>
                  <td> <?php echo $user->comment;?> </td>
                  <!-- <td> <?php echo $user->date_created;?> </td> -->
<td>
                  <a href='<?=base_url("litigationsList/edit_litigations/$user->id");?>' onclick="return confirm('Are you sure you want to edit this item?');"><i class="fa fa-edit"></i></a>
                  <a href='<?php echo base_url("litigationsList/delete_litigations/$user->id");?>' onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>

                  </tr>   
                      <?php }?>                 
                  </tbody>
                
                </table>
              </div>
            </div>
            <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <img src="" width="100%" height="inherit" id="target_element"> </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
  $('.image').click(function(){
    var image = $(this).attr('src');
    $('#target_element').attr('src',image);
    // $('#target_element').attr('width','300px');
    // $('#target_element').attr('height','300px');
  })

  $('#dtBasicExample').DataTable({
    "paging": true, // false to disable pagination (or any other option)
    "pageLength": 10
   
  });
})
  
</script>





<!-- Modal -->
