<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <!-- <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Barter Trade</a>
  
   -->
   <a class="navbar-brand" href="#">
      <img src="<?php echo base_url();?>assets/images/admin.png" width="50" height="50" class="d-inline-block align-top" alt="">
      <span style="font-family: 'Signika', sans-serif;font-size:35px;">Admin</span>
    </a>

  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
     
     <?php echo anchor("auth/auth/admin_logout","logout","class='btn btn-warning'");?>
    
    </li>
  </ul>
</nav>
