<?php
class scores {
    
}
class user {
    public function login($user,$password){
        global $dbh;
        global $install;
        global $VALID;
        try{
    
            $sql='SELECT * FROM users WHERE name=?';
            $query_user=$dbh->prepare($sql);
            $query_user->execute(array($user));
	    if($query_user->rowCount()>0){
		$user_information= $query_user->fetchAll(PDO::FETCH_ASSOC);
	    }else{
		//user not found
	    }
            //print_r($user_information[0][id]);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        //Compare stored Password to input password
        $stored_password=$user_information[0]['password'];
        if(password_verify($password,$stored_password)){
            //TODO:Log user login to file.
            	$_SESSION['name']=$user;
		$_SESSION['type']=$user_information[0]['type'];
		$_SESSION['perms']=$user_information[0]['permissions'];
		$_SESSION['loggedin']=true;
		$_SESSION['user']=true;
                echo '<META HTTP-EQUIV=Refresh CONTENT=".5; URL=index.php">';
                echo '<h2>You have logged in!</h2>';
        }else{
            //$log=new Logging();
	    //$log->add_entry("INVALID LOGIN:", "$user attempted to login and failed");
            echo '<h2>Wrong Username or passord</h2>';
        }
        
    }
    public function add_user($user,$password,$type,$permissions){
	global $dbh;
	$adding ="INSERT INTO users(name,password,type,permissions) VALUES(?,?,?,?)";
	$add = $dbh->prepare($adding);
	$password = password_hash($password,PASSWORD_DEFAULT);
	$add->execute(array($user,$password,$type,$permissions));
    }
}
class uploads{
    public function upload($name,$tmpName){						//Upload function for admin area excel files
	$target_path = "uploads/";
	$target_path = $target_path . basename($name); 
	if(move_uploaded_file($tmpName, $target_path)) {
	    //Moved file, no response due to trying to keep admin area simple
	    echo 'File moved to:'.$target_path;
	    $this->insert($target_path);
	} else{
	    echo "There was an error uploading the file, please try again!";
	}
	
	
	}
    public function insert($location){			//Addes uploaded Excel file data to database
	global $dbh;
	include('source/reader.php');
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($location);
		for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
		    $teamNumber = $data->sheets[0]["cells"][$x][1]; //a
		    $teamName = $data->sheets[0]["cells"][$x][2];//b
		    $division= $data->sheets[0]["cells"][$x][3];//c
		
			
			$check = "SELECT * FROM `teams` WHERE `teamName`=?"; //$name
		$qry = $dbh->prepare($check);
		$qry->execute(array($teamName));
		$num_rows = $qry->rowCount();
		if ($num_rows > 0) {
			echo "Sorry, the team ".$teamName." is already in use. Please please use another team name<br>";
		}else{
		    $sql = "INSERT INTO teams (teamName,teamNumber,division) VALUES (?,?,?)";
		    $add=$dbh->prepare($sql);
		    $add->execute(array($teamName,$teamNumber,$division));
		}
		//unlink($location);
		echo 'Your file has been input into the database. Thank you.';
	}
	}

}

class admin{
    public function numberTeams(){
        global $dbh;
    }
}
class events{
    public function return_events($type,$division){
        global $dbh;
        if($type==1){
            $sql = "SELECT * FROM events WHERE active=1 and division=? ORDER BY eventName ASC";
        }else if($type==3){
	    $sql = "SELECT * FROM events ORDER BY eventName ASC";
        }else{
            $sql = "SELECT * FROM events WHERE division=? ORDER BY eventName ASC";
        }
        $events = $dbh->prepare($sql);
        $events->execute(array($division));
        $event = $events->fetchAll();
        return $event;
    }
    public function unlock($event){
        global $dbh;
        //Unlock scores table first.
        $unlockEventSup = "UPDATE scores SET locked=0 WHERE eventName=?";
        $unlock = $dbh->prepare($unlockEventSup);
        $unlock->execute(array($event));
        //unlock event table
        $unlockEvents = "UPDATE events SET completed=0 WHERE eventName=?";
        $un = $dbh->prepare($unlockEvents);
        $un->execute(array($event));
    }
    public function number_events($type){
        global $dbh;
        if($type==1){
            $sql = "SELECT * FROM events WHERE active=1 ORDER BY eventName ASC";
        }else{
            $sql = "SELECT * FROM events ORDER BY eventName ASC";
        }
        $events = $dbh->query($sql);
        $event = $events->rowCount();
        return $event;
    }
    public function return_comp_events(){
        global $dbh;
        $sql = "SELECT * FROM events WHERE completed=1 ORDER BY eventName ASC";
        $events = $dbh->query($sql);
        $event = $events->rowCount();
        return $event;
    }
    public function add_events($eventName,$division,$type,$method){
        global $dbh;
        $sql = "INSERT INTO events(eventName,division,scoreMethod,type,active) VALUES(?,?,?,?,?)";
        $addEvent = $dbh->prepare($sql);
        $addEvent->execute(array($eventName,$division,$method,$type,1));
    }
    public function updateActive($event,$type){
        global $dbh;
        if($type==1){
            $sql = "UPDATE events SET active=1 WHERE eventName=?";
        }else{
            $sql = "UPDATE events SET active=2 WHERE eventName=?";
        }
        $activate = $dbh->prepare($sql);
        $activate->execute(array($event));
    }
    
    public function get_event($id,$returnVal){
        global $dbh;
        $sql = "SELECT * FROM events WHERE id =?";
        $eventname = $dbh->prepare($sql);
        $eventname->execute(array($id));
        $event = $eventname->fetchAll(); 
        if($returnVal == 1){
            return $event[0]['eventName'];
        }else{
            return $event[0]['division'];
        }
        
    }
    public function get_method($id){
        global $dbh;
        $sql = "SELECT * FROM events WHERE id =?";
        $eventname = $dbh->prepare($sql);
        $eventname->execute(array($id));
        $event = $eventname->fetchAll(); 
        return $event[0]['scoreMethod'];
        
    }

}
class stats{
    public function numberCompleted(){
        global $dbh;
       //get number of events where completed=1
       //this will be the evnets that have been sumitted and then confirmed.
       $get = "SELECT * FROM events WHERE completed=1 AND comfirmed=1";
       $getting = $dbh->query($get);
       $numberDone= $getting->rowCount();
        return $numberDone;
    }
}
class display{
    public function list_comp_events(){
        $events = new events;
        $list = $events->return_comp_events();
        foreach($list as $event){
            echo '<h4>'.$event['eventName'].'</h4>';
        }
    }
    public function table_of_teams(){
            global $dbh;
            $sqlB = "SELECT * FROM teams WHERE division='B'";
            $sqlC = "SELECT * FROM teams WHERE division='C'";
            $teamB = $dbh->query($sqlB);
            $teamB = $teamB->fetchAll();
            $teamC =  $dbh->query($sqlC);
            $teamC = $teamC->fetchAll();
            echo '<table class="table table-striped table-bordered table-condensed table-hover" style="float:left; width:400px; margin-left: 30px;"><tr><th>B Teams</th></tr>';
            foreach($teamB as $team){
                echo'<tr><td>'.'<div style="display:inline" class="edit_number" id="'.$team['teamNumber'].'">'.$team['teamNumber'].'</div>'.' '.'<div style="display:inline" class="edit_name" id="'.$team['teamName'].'">'.$team['teamName'].'</div>'.'</td></td>';
            }
            echo '<table class="table table-striped table-bordered table-condensed table-hover" style="float:left; width:400px; margin-left: 30px;"><tr><th>C Teams</th></tr>';
            foreach($teamC as $team){
                  echo'<tr><td>'.'<div style="display:inline" class="edit_number" id="'.$team['teamNumber'].'">'.$team['teamNumber'].'</div>'.' '.'<div style="display:inline" class="edit_name" id="'.$team['teamName'].'">'.$team['teamName'].'</div>'.'</td></td>';
            }
        
        
    }
    public function number_teams($division){
        global $dbh;
        $sql = "SELECT * FROM teams WHERE division=?";
        $number = $dbh->prepare($sql);
        $number->execute(array($division));
        $numTeams = $number->rowCount();
        return $numTeams;
    }
    public function return_teams($division){
        global $dbh;
        $sql = "SELECT * FROM teams WHERE division =?";
        $teams = $dbh->prepare($sql);
        $teams->execute(array($division));
        $teams = $teams->fetchAll();
        return $teams;
    }
    public function return_teams_sorted($division){
        global $dbh;
        $sql = "SELECT * FROM teams WHERE division =? ORDER BY rank ASC";
        $teams = $dbh->prepare($sql);
        $teams->execute(array($division));
        $teams = $teams->fetchAll();
        return $teams;
    }
    public function list_teams(){
        global $dbh;
        
    }
    public function score_sheet(){
        include('templates/template_scoresheet.php');
    }
    public function list_events($type,$division){
         $EventClass = new events;
        $events = $EventClass->return_events(1,$division);
        if($type == 1){
            $link = 'scores.php?event=';
        }else{
             $link = 'counsler.php?event=';   
        }
        echo '<table class="table table-striped table-bordered table-condensed table-hover"
        style="float:left; width:400px; margin-left: 30px;"><tr><th>'.$division.' Division Events</th></tr>';
        foreach( $events as $event){
            echo '<tr><td><a href='.$link.$event['id'].'>'.$event['division'].' '.$event['eventName'].'</a></td></tr>';
        }
        echo '</table>';
    }
    public function admin_events($division){
         $EventClass = new events;
        $events = $EventClass->return_events(3,$division);
        echo '<table class="table table-striped table-bordered table-condensed table-hover">';
        echo "<tr><th>Event</th><th>Event Being Run</th><th>Division</th><th>Type</th><th>Scoring Method</th><th>Locked</th><th>Confirmed</th></td>";
        foreach($events as $event){
            if($event['active'] == 1){
                $active = 'Yes';
            }else{
                $active = 'No';
            }
            if($event['scoreMethod']=='high'){
                $scoring='High to Low';
            }else if($event['scoreMethod']=='low'){
                $scoring='Low to High';
            }else{
                $scoring= 'Defaulted to High to Low';
            }
            $eventName = $event['eventName'];
            $unlockButton = "<form method=Post action= ><input type=hidden value=$eventName name=eventName />
            <input type=submit value=Unlock name=unlock></form>";
            if($event['completed']==1){
                $eventSup = 'Submitted by Event Supervisor<br/>'.$unlockButton;
            }else{
                $eventSup = 'Not Yet Submitted';
            }
            if($event['confirmed']==1){
                $sc = 'Score Counselor has confirmed';
            }else{
                $sc = 'Not Yet Confirmed';
            }
	    if($event['type']=='event'){
		$type = 'Official Event';
	    }else{
		$type ='Trial Event';
	    }
            echo '<tr><td><label><input type="checkbox" value="'.$event['eventName'].'" name="setActive[]"/>'
            .'<div style="display:inline" class="edit_event" id="'.$event['eventName'].'">'.$event['eventName'].'</div>'.
            '</label></td><td>'.$active.'</td><td><div style="display:inline" class="edit_div" id="'.$event['eventName'].'">'
            .$event['division'].'<td>'.$type.'</td><td>'.$scoring.'</td><td>'.$eventSup.'</td><td>'.$sc.'</td>'.
            
            '</tr>';
        }
        echo "</table>";
    }
    public function add_teams($name,$number,$d){
        global $dbh;

        $sql = "INSERT INTO teams(teamName,teamNumber,division) VALUES (?,?,?);";
        //$sql = "INSERT INTO teams(teamName,teamNumber,division) VALUES(?,?,?)";
        $add = $dbh->prepare($sql);
        $add->execute(array($name,$number,$d));
    }
}
?>