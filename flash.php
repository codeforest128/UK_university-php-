      <?php if(isset($_SESSION['flash'])){ ?>
    
            
            
            <!-- The Modal -->
<div class="modal" id="notification_mdl">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php echo $_SESSION['flash']; ?>
        
        

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<script>
setTimeout(function(){ $('#notification_mdl').modal('show'); }, 1000);
    
</script>
            
            
            
            <?php

           unset($_SESSION['flash']);

         } ?>