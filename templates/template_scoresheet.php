<?php
$display = new display;
$event = new events;
if(is_numeric($_GET['event'])){
    $id = $_GET['event'];
}else{
    $id = 0;
}
if($id !=0){
$eventName = $event->get_event($id,1);
$division = $event->get_event($id,2);
$numTeams = $display->number_teams($division);
}else{
    //throw error;
}
$rankType=$event->get_method($id);
if($rankType=='high'){
    $rankType='High to Low';
    $numRankType = 2;
}else if($rankType=='low'){
    $rankType='Low to High';
    $numRankType = 1;
}else{
    $rankType='High to Low';
    $numRankType = 2;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!--
/*
 * 
 * This grid setup  is part of EditableGrid.
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
-->

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Score Sheet</title>
		<script type="text/javascript" src="jquery-2.1.1.min.js
		"></script>


	<!--	<script src="editablegrid-2.0.1.js"></script>
		<link rel="stylesheet" href="editablegrid-2.0.1.css" type="text/css" media="screen">-->
		
		<!--<style>
			body { font-family:'lucida grande', tahoma, verdana, arial, sans-serif; font-size:11px; }
			h1 { font-size: 15px; }
			a { color: #548dc4; text-decoration: none; }
			a:hover { text-decoration: underline; }
			table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 800px; }
			table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
			table.testgrid th { background: #E5E5E5; text-align: left; }
			input.invalid { background: red; color: #FDFDFD; }
		</style>-->
		
		<script>
			var scores = [];
			var sortMethod = <?php echo $numRankType;?>; //1 is a low to high sort, two is a high to low sort.
			var max =  <?php echo $numTeams;?>;
			var teams_participating = 0;
                        var eventName = <?php echo '"'.$eventName.'"';?>;
			// [[row,score,tier,tieplace,tie]]
			//for x<max totalPlacement.push([])
			//var totalPlacement = [[],[],[],[],[],[]];
			var totalPlacement = [];
			var finalPlacement = [];
			function create_total_placement(){
				var emptyArray =[];
				for(x=0;x<max;x++){
					//create array, and populate number of rows
					totalPlacement[x] = [3]; //create an array of three at each pount
					
					totalPlacement[x][0] = x+1;	//add the row index for the table
					totalPlacement[x][3] =0; //set default to false for ties
					totalPlacement[x][4] = 0; //det default place for ties to 0.
				}
				
			}
			function add_rows_to_array() {
				//loop through and add the row number, first thing to do. part of creation of the array?
				for(x=0;x<max;x++){
					totalPlacement[x][0]=x+1;
				}
			}
			function save_score_to_cell(scoreNum,schoolName,tiePlace,placeR,tierR) {
			    $.ajax({
					type: "POST",
					url: "bridges/individualscores.php",
					data: { event: eventName, score: scoreNum,school:schoolName,placeInTie:tiePlace,place: placeR,tier: tierR }
					})
					.done(function( msg ) {
					    if (msg.length>0) {
						document.getElementById('locked').innerHTML = 'This Event has been submitted, and is now Locked';
					    
					    }
					});
				}
			
			function checkNetConnection(){
			    var xhr = new XMLHttpRequest();
			    var file = "http://yoursite.com/somefile.png";
			    var r = Math.round(Math.random() * 10000);
			    xhr.open('HEAD', file + "?subins=" + r, false);
			    try {
			     xhr.send();
			     if (xhr.status >= 200 && xhr.status < 304) {
			      return true;
			     } else {
			      return false;
			     }
			    } catch (e) {
			     return false;
			    }
			   }
			function saveScores(){
				localStorage.setItem(eventName, JSON.stringify(totalPlacement));
				//send raw scores across to be stored.
				$.ajax({
					type: "POST",
					url: "bridges/save.php",
					data: { event: eventName, scores: JSON.stringify(totalPlacement)  }
					})
					.done(function( msg ) {
					if (msg.length>0) {
					    document.getElementById('locked').innerHTML = 'This Event has been submitted, and is now Locked';
					
					}
					});
				
			}
			function loadScores() {
				totalPlacement = JSON.parse(localStorage.getItem(eventName));
				for (z=0;z<max;z++) {
					row = totalPlacement[z][0];
					score = totalPlacement[z][1];
					tier = totalPlacement[z][2];
					scoreLoc = (z+1)+'score';
					tierLoc = (z+1)+'tier';
					//console.log(scoreLoc);
					document.getElementById(scoreLoc).value=score;
					document.getElementById(tierLoc).value=tier;
					/*editableGrid.setValueAt(row-1,1,score,true);
					editableGrid.setValueAt(row-1,2,tier,true);*/
				}
			}
			function compareScores(a,b) {
				//if sort method is set to 2 for a high to low sort it will return that, otherwise defualts to low to high
					if (sortMethod == 2) {
						return parseFloat(b[1]) - parseFloat(a[1]);
					}else{
						
						return parseFloat(a[1]) - parseFloat(b[1]);
					}
					
				}
			function compareties(a,b) {
				//if sort method is set to 2 for a high to low sort it will return that, otherwise defualts to low to high
					if (sortMethod == 2) {
						return parseFloat(b[4]) - parseFloat(a[4]);
					}else{
						return parseFloat(a[4]) - parseFloat(b[4]);
					}
					
				}
			function ranking(){
				//function to take all scores and rank them, start by sorting them into tier arrays, tier one two and three
				//then sort each array based on final score, then merge back into the totalPlacement Array.
				//tier arrays.
				var one = [];
				var two = [];
				var three = [];
				var four = [];
                                var NS = [];
                                var DQ = [];
                                var P =[];
				teams_participating = 0;
				for (x=0; x<max; x++) {
				    if (totalPlacement[x][1] != 0 && totalPlacement[x][1] != "") {
					//update number of teams participating
					teams_participating ++;
					if (totalPlacement[x][1] == "P" ) {
					    P.push(totalPlacement[x]);
					
					}else if(totalPlacement[x][1] == "NS"){
					    NS.push(totalPlacement[x]);    
					}else if(totalPlacement[x][1] == "DQ"){
					    DQ.push(totalPlacement[x]);    
					}else if (totalPlacement[x][2]==1) {
						one.push(totalPlacement[x]);
					}else if (totalPlacement[x][2]==2) {
						two.push(totalPlacement[x]);
					}else if (totalPlacement[x][2]==3) {
						three.push(totalPlacement[x]);
					}else if (totalPlacement[x][2]==4) {
						four.push(totalPlacement[x]);
					}else{
						//error
					}
				    }else if (totalPlacement[x][1] == "") {
						//remove any place if applicable.
						row = totalPlacement[x][0];
						Srow = row+'place';
						if (document.getElementById(Srow)) {
							document.getElementById(Srow).innerHTML = "";
						}
				    }
					
				}
				//sort based on teirs
				one.sort(compareScores);
				two.sort(compareScores);
				three.sort(compareScores);
				four.sort(compareScores);
				//clear old array;
				finalPlacement.length=0;
				//build final place array
				for(x=0;x<one.length;x++){
					finalPlacement.push(one[x]);
				}
				for(x=0;x<two.length;x++){
					finalPlacement.push(two[x]);
				}
				for(x=0;x<three.length;x++){
					finalPlacement.push(three[x]);
				}
				for(x=0;x<four.length;x++){
					finalPlacement.push(four[x]);
				}
				for(x=0;x<P.length;x++){
					finalPlacement.push(P[x]);
				}
				for(x=0;x<NS.length;x++){
					finalPlacement.push(NS[x]);
				}
				for(x=0;x<DQ.length;x++){
					finalPlacement.push(DQ[x]);
				}
				for(y=0;y<finalPlacement.length;y++){
					//check ties, if there is a tie skip and put in the ti
					rowLocal = finalPlacement[y][0];
					//tie = check_tie(x);
					tie = check_all_ties(finalPlacement[y][1],finalPlacement[y][2]);
					if (finalPlacement[y][1] == "P") {
					    placeValue = teams_participating;
					}else if (finalPlacement[y][1] == "NS") {
					    placeValue = teams_participating +1;
					}else if (finalPlacement[y][1]=="DQ") {
					    placeValue = max +2;
					}else{
					   placeValue = y+1; 
					}
					placeLocat = rowLocal+"place";
					
					if (!tie) {
						tieDialoglocat = rowLocal +"tie";
						name = document.getElementById(finalPlacement[y][0]).innerHTML;
						//console.log(name);
						document.getElementById(tieDialoglocat).innerHTML = "";
						document.getElementById(placeLocat).innerHTML = placeValue;
						placeInTie = finalPlacement[y][4];
						save_score_to_cell(finalPlacement[y][1],name,placeInTie,placeValue,finalPlacement[y][2]);
					}else{
					    //in tie and not tie broken
						tieDialoglocat = rowLocal +"tie";
						row = 'R'+rowLocal;
						 if (finalPlacement[y][4] == 0 ) {
						    htmlString ='Place in Tie:<select name="'+rowLocal+'" id="'+rowLocal+'tieselect"class=ties><option></option>';
						    for(v=1;v<=max;v++){
							if (finalPlacement[y][4] == v) {
							    htmlString +='<option value="'+v+'" selected=selected>'+v+'</option>';
							}else{
							    htmlString +='<option value="'+v+'">'+v+'</option>';
							}
						    }
						    htmlString += '</select>'
						    document.getElementById(tieDialoglocat).innerHTML =htmlString;
						    document.getElementById(placeLocat).innerHTML = "tie";
						    name = document.getElementById(finalPlacement[y][0]).innerHTML;
						    document.getElementById(row).className = 'red';
 						    save_score_to_cell(finalPlacement[y][1],name,0,tie,finalPlacement[y][2]);
						    
						}else{
						    //Tie and tie broken.
						    htmlString ='Place in Tie:<select name="'+rowLocal+'" id="'+rowLocal+'tieselect"class=ties><option><option>';
						    for(v=1;v<=max;v++){
							if (finalPlacement[y][4] == v) {
							    htmlString +='<option value="'+v+'" selected=selected>'+v+'</option>';
							}else{
							    htmlString +='<option value="'+v+'">'+v+'</option>';
							}
						    }
						    htmlString += '</select>'
						    document.getElementById(tieDialoglocat).innerHTML =htmlString;
						    //document.getElementById(tieDialoglocat).innerHTML = finalPlacement[y][4];
						    
						    tieScore = finalPlacement[y][1];
						    tiePlace = 0;
						    for (u=0; u<finalPlacement.length;u++) {
							if (tieScore == finalPlacement[u][1] ) {
							    tiePlace = u;
							    break;
							}
						    }
						    placeValue=parseInt(tiePlace) + parseInt(finalPlacement[y][4])
						    document.getElementById(placeLocat).innerHTML = placeValue;
						    name = document.getElementById(finalPlacement[y][0]).innerHTML;
						    document.getElementById(row).className = 'blue';
						    placeInTie = finalPlacement[y][4];
						    save_score_to_cell(finalPlacement[y][1],name,placeInTie,placeValue,finalPlacement[y][2]);
						}
						
						/*saveIndex = y;
						score = finalPlacement[y][1];
						moveIn = y;
						tempArray = [];
						move = true;
						while (move) {
						    if (finalPlacment[moveIn][3]==1 && score == finalPlacement[moveIn][1]) {
							tempArray.push(finalPlacement[moveIn]);
						    }else{
							break; //we have left the score chunk
						    }
						    moveIn ++;
						}
						//now that we have a temp array lets sort it, and then readd it into the original
						tempArray.sort(compareTies);
						//length to cut out then readd
						cutArea = moveIn - saveIndex;
						totalPlacement.splice(saveIndex,cutArea,tempArray)
						*/
						//totalPlacement[rowLocal-1][3] = 1;
						
						
						
					}
					
					
				}
			
			}
				function check_all_ties(value,tier){
					currentScores = [];
					currentTiers = [];
					
					//add scores to current List;
					for(x=1; x<=max;x++){
						scorelocation = x+"score";
						tierlocal = x+"tier";
						theScore = document.getElementById(scorelocation).value;
						theTier = document.getElementById(tierlocal).value;
						currentScores.push(theScore);
						currentTiers.push(theTier);
					}
					//console.log(currentScores);
					firstIndex = currentScores.indexOf(value);
					lastIndex = currentScores.lastIndexOf(value);
					if (value == 0) {
						return false;
					}else if ( firstIndex == lastIndex ) {
						//tie
						//return true
						return false;
						
					}else if(currentTiers[firstIndex] == currentTiers[lastIndex]){
						//make sure scores are in the same tier, otherwise it wont be a tie.
						totalPlacement[firstIndex][3] = 1;
						totalPlacement[lastIndex][3]=1;
						return true;
					}else{
						return false;
					}
					return false;
				}
			function updateTie(locationchange,placeInTie){
				//get scoere
				console.log(placeInTie)
				scorePlace = locationchange +'score';
				tiePlace = locationchange +"tie"
				originalScore = document.getElementById(scorePlace).value;
				stringAdd = '.0'+placeInTie;
				toAdd = parseFloat(originalScore)+parseFloat(stringAdd);
				//update score
				totalPlacement[locationchange-1][4] = placeInTie;//store the location of place
				
				//editableGrid.setValueAt(locationchange-1,1,toAdd,true);
				document.getElementById(tiePlace).innerHTML = toAdd;
				ranking();
				//update_scores();
			}
			function update_scores(scoreIn){
				
				//function to update scores...
				//loop through scores and add them to the array, updating them if nessisary.
				for(x=1; x<=max;x++){
					scorelocation = x+"score";
					tierlocal = x+"tier";
					theScore = document.getElementById(scorelocation).value;
					theTier = document.getElementById(tierlocal).value;
					totalPlacement[x-1][2] = theTier;
					
					if (parseFloat(theScore) != 0) {
						totalPlacement[x-1][1] = theScore;
					}
					/*isTie = check_all_ties(totalPlacement[x-1][1],x-1,totalPlacement[x-1][2]);
					if (isTie) {
						if (document.getElementById(x+'ties')) {
							totalPlacement[x-1][3] = document.getElementById(x+'ties').value;
						}
						
					}*/
				}
				saveScores();
				ranking();
			}
			function supports_html5_storage() {
				try {
				  return 'localStorage' in window && window['localStorage'] !== null;
				} catch (e) {
				  return false;
				}
			}
			function final_save(){
			    for(x=1; x<max+1;x++){
				scoresL = x+"score";
				tier = x+"tier";
				place = x+"place"
				placeR = document.getElementById(place).innerHTML;
				scoreNum = document.getElementById(scoresL).value;
				
				tierR = document.getElementById(tier).value;
				schoolName=document.getElementById(x).innerHTML;
				 $.ajax({
					type: "POST",
					url: "bridges/individualscores.php",
					    data: { event: eventName, score: scoreNum,school:schoolName,place: placeR,tier: tierR, locked:"1" }
				    })
				    .done(function( msg ) {
					if (msg.length>0) {
					    document.getElementById('locked').innerHTML = 'This Event has been submitted, and is now Locked';
					
					}
					    //alert( "Data Saved: " + msg );
						console.log(msg);
				    });
			    }
			    document.getElementById('locked').innerHTML = 'This Event has been submitted, and is now Locked';
			}
			function showSaved() {
			    document.getElementById('saved').innerHTML = 'Event Has been Saved';
			}
			function removeSaved() {
			     document.getElementById('saved').innerHTML = '';
			}
			var timeoutID;

			function delayedSave() {
			  timeoutID = window.setTimeout(showSaved, 500);
			  timeoutID = window.setTimeout(removeSaved, 4000);
			}
			window.onload = function() {
				//see if local storage has a scores array
				if (localStorage.getItem(eventName)) {
					loadScores();
					update_scores();
				}else{
					create_total_placement();
				}
					
			}
			 $(document).on("change",'.score', function() {
			    newScore = $(this).val();
			    
					update_scores(newScore);
					saveScores();
			 });
			  $(document).on("change",'.tiers', function() {
					update_scores();
					saveScores();
			 });
			 $(document).on("change",'.ties', function() {
				rowPlace = $(this).attr('name');
				placeInTie = $("option:selected", this).val();
				//alert(placeInTie);
				updateTie(rowPlace,placeInTie);
			});
		</script>
		
	</head>
	
	<body>
		<?php include('nav.php');?>
		<h1><?php echo $division.' '.$eventName;?></h1>
		<h2 id="locked"></h2>
		<h2 id="saved"></h2>
		
		<h3>Event Supervisors, enter your scores, they will be saved automatically.
		Once ALL of your scores are in hit save and submit, then report to score counseling</h3>
		<ul>
		    <li>Ranking: <?php echo $rankType?></li>
		    <li>1st in tie recieves more favorable rank</li>
		    <li>Tier 1 receives more favorable rank</li>
		</ul>
		<div class="table-responsive">
		<table  class="table table-bordered table-condensed">
			<tr>
				<th>School</th>
				<th>Raw Score</th>
				<th>Tier</th>
				<th>Tie Break</th>
				<th>Place</th>
							</tr>
                        <?php
                            $team = $display->return_teams($division);
                            $x = 1;
                            foreach($team as $data){
                                echo '<tr id="R'.$x.'">
				<td id='.$x.'>'.$data['teamNumber'].' '.$data['teamName'].'</td>
				<td><input type="text" name="'.$x.'" class="score" id="'.$x.'score" /></td>
				<td>
					<select name="1" class="tiers" tabindex="-1" id="'.$x.'tier">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</td>
				<td id="'.$x.'tie"></td>
				<td id="'.$x.'place"></td>
			</tr>';
                            $x+=1;
                            }?>
			
		</table>
		<button onclick="delayedSave()">Save</button>
		<button onclick="final_save()">Save and Submit</button>
		</div>
	</body>
	
</html>
