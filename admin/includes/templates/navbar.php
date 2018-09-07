<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li ><a href="categories.php"><?php echo lang('CATEGORIES'); ?> </a></li> <!-- Language Function -->
        <li ><a href="items.php"><?php echo lang('ITEMS'); ?> </a></li> <!-- Language Function -->
        <li ><a href="members.php"><?php echo lang('MEMBERS'); ?> </a></li> <!-- Language Function -->
        <li ><a href="comments.php"><?php echo lang('COMMENTS'); ?> </a></li> <!-- Language Function -->
        <!--<li ><a href="#"><?php //echo lang('STATISTICS'); ?> </a></li>--> <!-- Language Function -->
        <!--<li ><a href="#"><?php // echo lang('LOGS'); ?> </a></li>--> <!-- Language Function -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hamam<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../indexAdmin.php">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>">Edit Profile</a></li>
            <li><a href="#">Sittings</a></li>
            <li><a href="logout.php">LogOut</a></li>            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

