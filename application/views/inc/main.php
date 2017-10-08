
  <div class="thirteen wide column" id="content" style="padding-top:1rem">
  <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('userID');?>">
  <input type="hidden" name="user_type" value="<?php echo $this->session->userdata('userTitle'); ?>">
  <?php echo $content; ?>
</div>
</div>
