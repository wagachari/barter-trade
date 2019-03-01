<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <!-- <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Barter Trade</a>
  
   -->
   <a class="navbar-brand" href="#">
      <img src="<?php echo base_url();?>assets/images/icons8-bebo-filled-480.png" width="50" height="50" class="d-inline-block align-top" alt="">
      <span style="font-family: 'Signika', sans-serif;font-size:35px;">arter tade</span>
    </a>
  <input class="form-control form-control-dark w-100 " name="search" type="text" placeholder="Search" aria-label="Search" ><button name="Submit" class="default"><span><i class="fas fa-search"  ></i></span></button>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
     
     <?php echo anchor("auth/auth/admin_logout","logout","class='btn btn-warning'");?>
    
    </li>
  </ul>
</nav>
