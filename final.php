<?php
include('header.php');
$display = new display();
$events = new events();
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$division = $_GET['division'];
$teams = $display->return_teams($division);
$numTeams = $display->number_teams($division);
$listEvents = $events->return_events(1,$division);
global $dbh;
?>
<html>
<head>
      <script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
		<script src="source/jquery.jeditable.js" type="text/javascript"></script>
				<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="source/bootstrap/css/bootstrap.css">
		<!-- Extra Themes -->
		<link rel="stylesheet" href="source/parts.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="source/bootstrap/js/bootstrap.min.js"></script>
		<script src="source/editing.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Score Sheet</title>
		<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
       <script>
       
       var max = <?php echo $numTeams; ?>;
       var scores = [max];
       var sortMethod = 1;  //low to High Sort.
       var medalPlaces=[];
       var toSort=[];
       function compareScores(a,b) {
				//if sort method is set to 2 for a high to low sort it will return that, otherwise defualts to low to high
					if (sortMethod == 2) {
						return parseFloat(b[2]) - parseFloat(a[2]);
					}else{
						
						return parseFloat(a[2]) - parseFloat(b[2]);
					}
					
				}
       function fixTies(a,b) {

	      return parseFloat(b[1]) - parseFloat(a[1]);

       }
       function breakTies(a,b) {

	      return parseFloat(a[4]) - parseFloat(b[4]);

       }
       function ranking() {
              //add all scores to array.
              for (x=0;x<max;x++) {
                     scores[x]=[4]
                     team = x+'team';
                     scoreL = x+'score';
                     score = document.getElementById(scoreL).innerHTML;
                     teamName = document.getElementById(team).innerHTML;
                     scores[x][0]=x;
                     scores[x][1]=teamName;
                     scores[x][2]=score;
              }
              //sort array.
              scores.sort(compareScores);
              for(x =0; x<max;x++){
                     scores[x][3]=x+1;
              }
              if (scores[0][2]!=0) {
                     check_ties();
                     writePlaces();
              }else{
		check_ties();
                     writePlaces();
	      }
              
       }
       function writePlaces() {
              for(x =0; x<max;x++){
                     //scores[x][3]=x+1; //write Place to array as well.
                     finalP = scores[x][0] +'rank';
                     rank = scores[x][3];
                     document.getElementById(finalP).innerHTML = rank;
              }
       }
       function check_ties(){
              totalLength = scores.length;
                     
              for(x = 0; x<max;x++){
                     ties = [];
                     startLocation = 0;
                     y=x;
                            while(y< totalLength){
                                   if (y < totalLength-1) {
					  console.log(y);
					  console.log(totalLength);
                                          if (scores[y][2] == scores[y+1][2]) {
                                                 startLocation = y;
                                               len = ties.length;
                                                if(ties[len-1] != scores[y][1]){
                                                 ties.push([]);
	      				  console.log(scores[y][2]);
					  console.log(len);
                                                 ties[len][0]=scores[y][1];
                                                 ties[len][2]=0;
                                                }
                                                 ties.push([]);
                                                 ties[len+1][0]=scores[y+1][1];
                                                 ties[len+1][2]=0;
                                               
                                          }else{
                                                 break;
                                          }
                                   
                                    }
                                    y++;
                                    x++;
                            }
                            
                     //loop and check ties based on array;
                     tied = false;
                     console.log(ties);
                    if (ties.length>0) {
                            tied = true;
                    }
                    placeCheck = 1;
                    placing=1;
                    while(tied){
                            //grab places to check
                            toGet =[];
                            $ni=0;
                            for(q=0;q<ties.length;q++){
                                   if (ties[q][2]==0) {
                                          toGet[$ni]=ties[q];
                                          $ni++;
                                   }
                            }
                           // console.log(toGet);
                           for(z=0;z<toGet.length;z++){
                                   teamCheck = toGet[z][0];
                                   if (toGet[z][2]==0) {
                                          //code
                                   
                                   $.ajax({
                                          type: "POST",
                                          async: false,
                                          url: "bridges/check_tie.php",
                                          data: { team:teamCheck,place:placeCheck },
                                           success: function(msg){
                                                 toGet[z][1]= msg;
                                                
                                             }
                                          });
                                   }
                     

                            }
                            //loop through and see if any are teh same, I.e there is a tie in number of medals
                            toGet.sort(fixTies);
                            
                                        
                            for (n=0;n<toGet.length;n++) {
                                   //console.log(toGet.length);
                                   //console.log(n+1);
                                   if ((n+1)<toGet.length) {
                                          
                                          if (toGet[n][1]!=toGet[n+1][1]) {
                                                 toGet[n][2]=n+1;
                                                 toGet[n][3]=placeCheck;
                                                 toGet[n][4]=placing;
                                                 placing+=1;
                                          }
                                   }else if (n==(toGet.length-1)) {
                                          //if last then check the previous
                                         if (toGet[n][1]!=toGet[n-1][1]) {
                                                 toGet[n][2]=n+1;
                                                 toGet[n][3]=placeCheck;
                                                 toGet[n][4]=placing;
                                                 placing+=1;
                                          }
                                   }

                            }
                           // console.log(ties);
                            //merge the arrays
                            for(r=0;r<toGet.length;r++){
                                   for(t=0;t<ties.length;t++){
                                          if (ties[t][0]==toGet[r][0]) {
                                                 ties[t]=toGet[r];
                                          }
                                   }
                            }
                            index=0;
                            for(d=0;d<ties.length;d++){
                                   if(ties[d][0]){
                                          index=d;
                                   }
                            }
                            ties = ties.slice(0,index+1)
                            //console.log(index+1);
                            //console.log(ties);
                            if (ties[index][2]==0) {
                                   tied=true;
                                   placeCheck+=1;
                            }else{
                                   tied = false;
                            }
                    }
                   ties.sort(breakTies);
                   //loop through scores and ties and update final placement.
                   for(p=0;p<ties.length;p++){
                     for (v=0;v<scores.length;v++) {
                            if (scores[v][1]==ties[p][0]) {
                                   scores[v][3]=(startLocation+ties[p][4]);
                            }
                     }
                   }
              }
              
       }
       function submitRank(){
              for(x=0; x<max;x++){
				nameP=x+'team';
                                rankP = x+'rank';
                                
                                 name=document.getElementById(nameP).innerHTML;
                                 numIn = name.indexOf(" ");
                                 name = name.substring(numIn+1);
                                 rank = document.getElementById(rankP).innerHTML;
                                 console.log(name);
				 $.ajax({
					type: "POST",
					url: "bridges/submitRank.php",
					    data: { school:name,rank:rank }
				    })
				    .done(function( msg ) {
				   
				    });
			    }
                            document.getElementById("status").innerHTML='<h3><a href="results.php">View the Results</a></h3>';
       }
       window.onload = function() {
              
              ranking();
            };
</script>
       
</head>
       <body>
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
 
                      <li ><a href="index.php">Main Page</a></li>
    
                       <li ><a href="admin_events.php">Events</a></li>
     
                      <li ><a href="admin_users.php">Control Users</a></li>

                    <li ><a href="admin_teams.php">Teams</a></li>
	      <?php if($division=='B'){?>
                     <li class="active"><a href="final.php?division=B">Confirm B</a></li>
		     <li ><a href="final.php?division=C">Confirm C</a></li>
	    <?php  }else{ ?>
		     <li ><a href="final.php?division=B">Confirm B</a></li>
                    <li class="active"><a href="final.php?division=C">Confirm C</a></li>
	 <?php     }
?>
                 <li ><a href="admin_results.php">Award List</a></li>
		 <li ><a href="adminSettings.php">Results Settings</a></li>
		 <li> <a href="results.php">Results</a></li>
		 <li ><a href="logout.php">Logout</a></li>
    
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
      <div class="container">
              <h1>Confirm Scores</h1>
	      <ul>
		     <li>Score will only appear once the Score Counselor has approved them.</li>
		     <li><a href="admin_events.php">Check the event page for status</a></li>
	      </ul>
              <?php
echo '<table class="table table-striped table-condensed table-hover table-header-rotated"> <thead><tr>
<th class="rotate-45"><div><span>Teams</span></div></th>';
foreach($listEvents as $event){
      // echo '<th>'.$event['eventName'].'</th>';
      echo '<th class="rotate-45"><div><span>'.$event['eventName'].'</span></div></th>';
    }

echo '<th class="rotate-45"><div><span>Final Score</span></div></th>
<th class="rotate-45"><div><span>Rank</span></div></th></tr>
</thead>';
$x=0;
foreach($teams as $team){
    $team = $team['teamNumber'].' '.$team['teamName'];
    echo '<tr><td id="'.$x.'team">'.$team.'</td>';
    $score =0;
    foreach($listEvents as $event){
        $eventName = $event['eventName'];
        //echo '<td>'.$eventName.'</td>';
        $sql = "SELECT * FROM scores WHERE eventName=? AND teamName=?";
        $returnPlace = $dbh->prepare($sql);
        $returnPlace->execute(array($eventName,$team));
        $returnPlace = $returnPlace->fetchAll();
        if($event['type']=='event'){ //only add to final score if not a trial.
              $score += $returnPlace[0]['confirmedPlace'];
        }
        echo '<td>'.$returnPlace[0]['confirmedPlace'].'</td>';
    }
    echo '<td id="'.$x.'score">'.$score.'</td>';
    echo '<td id="'.$x.'rank"></td></tr>';
    $x++;
    }
    
?>

</table>
<button onclick="submitRank()" class="btn btn-primary">Confirm Scores</button>
<div id="status"></div>