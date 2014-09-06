<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Score Sheet</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php
            //lets do event Supervisors first
            if($_SESSION['loggedin']){
                if($_SESSION['type']==3 || $_SESSION['type'] ==2){
                   echo '<li class="active"><a href="index.php">Main Page</a></li>
                   <li ><a href="logout.php">Logout</a></li>
                   ';
                }
                if($_SESSION['type']==1){
                  
                   if(strpos($actual_link,'index')){
                    echo '<li class="active"><a href="index.php">Main Page</a></li>';
                   }else{
                      echo '<li ><a href="index.php">Main Page</a></li>';
                   }

                   if(strpos($actual_link,'admin_events.php')){
                      echo ' <li class="active"><a href="admin_events.php">Events</a></li>';
                    }else{
                       echo '<li ><a href="admin_events.php">Events</a></li>';
                    }
                    if(strpos($actual_link,'admin_users.php')){ //change to users
                    echo '<li class="active"><a href="admin_users.php">Control Users</a></li>';
                   }else{
                      echo '<li ><a href="admin_users.php">Control Users</a></li>';
                   }
                    if(strpos($actual_link,'admin_teams.php')){
                    echo ' <li class="active"><a href="admin_teams.php">Teams</a></li>';
                    }else{
                    echo '<li ><a href="admin_teams.php">Teams</a></li>';
                    }
                     if(strpos($actual_link,'final.php?division=B')){
                    echo ' <li class="active"><a href="final.php?division=B">Confirm B</a></li>';
                     }else{
                    echo '<li ><a href="final.php?division=B">Confirm B</a></li>';
                    }
                     if(strpos($actual_link,'final.php?division=C')){
                    echo ' <li class="active"><a href="final.php?division=C">Confirm C</a></li>';
                     }else{
                   echo ' <li ><a href="final.php?division=C">Confirm C</a></li>';
                    }
                    echo '<li><a href="admin_results.php">Award List</a></li>';
                   echo ' <li ><a href="adminSettings.php">Results Settings</a></li>';
                    echo '<li ><a href="logout.php">Logout</a></li>';
                } 
                
            }else{
               echo '<li class="active"><a href="login.php">Please Login</a></li>';
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
      <div class="container">
