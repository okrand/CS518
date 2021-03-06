<?php 
include_once "thingsandstuff.php";
session_start();

function getvotes($type, $threadID){
        $voteQuery = "SELECT * FROM VOTES WHERE VOTER_ID = " . $_SESSION["UserID"] . " AND THREAD_TYPE = '" . $type . "' AND THREAD_ID = " . $threadID . ";";
        $voteresult = sqlcommand($voteQuery, "SELECT");
        if ($voteresult == false)
            return 0;
        $voteresult = $voteresult->fetch_assoc();
        return $voteresult["UPORDOWN"];
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Q&A page for HighSide - The Motorcycle Q&A Website">
<title>Let's see what our experts said</title>
<?php bringLibraries(); ?>
<script>
function CheckLength(){    
var msg_area = document.getElementById("lengthalert");
msg_area.innerHTML = "";
if (document.getElementById("Answer").value.length < 2) {
    msg_area.style.display = 'block';
    msg_area.innerHTML = "<strong>Your answer needs to be between 2-500 characters</strong>";
}
else {
    document.getElementById("newAnswer").submit();
}
}
</script>
<script>
function CheckLength2()
{
var msg_area = document.getElementById("questiontextarea");
msg_area.innerHTML = "";
if (document.getElementById("Answer").value.length < 2) {
    msg_area.style.display = 'block';
    msg_area.innerHTML = "<strong>Your question needs to be between 2-500 characters</strong>";
}
else 
    document.getElementById("edit").submit();
}
</script>
<!--Voting script -->
<script>
    function vote(upOrDown, QorA, threadID, OID, UID){
    var badgeName = "badge" + OID;
    var badges = document.getElementsByName(badgeName);
    if (QorA == "Q"){
        if (upOrDown == 1){ //upvote
            if (document.getElementById("votedownQ").getAttribute("src") == "downvoteActive.png") {
                document.getElementById("qPoint").innerHTML++;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML++;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML++;
            }
            if (document.getElementById("voteupQ").getAttribute("src") != "upvoteActive.png") {
                document.getElementById("qPoint").innerHTML++;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML++;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML++;
            }
            document.getElementById("voteupQ").src = "upvoteActive.png";
            document.getElementById("votedownQ").src = "downvote.png";
        }
        else if (upOrDown == 0){
            document.getElementById("voteupQ").src = "upvote.png";
            document.getElementById("votedownQ").src = "downvote.png";
        }
        else{ //downvote
            if (document.getElementById("voteupQ").getAttribute("src") == "upvoteActive.png") {
                document.getElementById("qPoint").innerHTML--;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML--;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML--;
            }
            if (document.getElementById("votedownQ").getAttribute("src") != "downvoteActive.png") {
                document.getElementById("qPoint").innerHTML--;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML--;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML--;
            }
            document.getElementById("votedownQ").src = "downvoteActive.png";
            document.getElementById("voteupQ").src = "upvote.png";
        }
        }
    if (QorA == "A"){
        var up="voteupA" + threadID;
        var down="votedownA" + threadID;
        var point="aPoint"+threadID;
        if (upOrDown == 1){
            if (document.getElementById(down).getAttribute("src") == "downvoteActive.png") {
                document.getElementById(point).innerHTML++;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML++;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML++;
            }
            if (document.getElementById(up).getAttribute("src") != "upvoteActive.png") {
                document.getElementById(point).innerHTML++;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML++;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML++;
            }
            document.getElementById(up).src = "upvoteActive.png";
            document.getElementById(down).src = "downvote.png";
        }
        else if (upOrDown == 0){
            document.getElementById(up).src = "upvote.png";
            document.getElementById(down).src = "downvote.png";
        }
        else{
            if (document.getElementById(up).getAttribute("src") == "upvoteActive.png") {
                document.getElementById(point).innerHTML--;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML--;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML--;
            }
            if (document.getElementById(down).getAttribute("src") != "downvoteActive.png") {
                document.getElementById(point).innerHTML--;
                for (var i=0, max=badges.length; i < max; i++) {
                   badges[i].innerHTML--;
                }
                if (OID == UID)
                    document.getElementById("K_Points").innerHTML--;
            }
            document.getElementById(down).src = "downvoteActive.png";
            document.getElementById(up).src = "upvote.png";
        }
        
    }
       $.post("vote.php", {voteType: upOrDown, votingWhat: QorA, ID: threadID, OwnerID: OID});
    }
    </script>
</head>
<body>    
   <header class="jumbotron text-center" style="background-color:white;">
        <h1>
        <a href="index.php">
        <img src="highside-logo.jpg" alt="HighSide" style="width:100px;height:150px;">
        </a>
        HighSide<br>Motorcycle Experience Sharing Platform </h1>
	</header>
    <div class="topMenu">
                    <div class="btn-group pull-left">
                        <?php
                            if (isset($_SESSION["UserID"])){
                            $query = "SELECT KARMA_POINTS FROM USERS WHERE ID = ". $_SESSION["UserID"] . ";";
                            $result = sqlcommand($query, "SELECT");
                            $result = $result->fetch_assoc();
                            echo '<label class="btn btn-info disabled">Welcome <a href="profile.php">' . $_SESSION["userName"].'</a> ' . '<span id="K_Points" class="badge">' . $result["KARMA_POINTS"] . '</span></label>';
                            }
                        if ($_SESSION["loggedIn"] == true){
                            echo '<button type="button" id="btnSearchUser" class="btn btn-info disabled" onclick="switchSearch(\'user\');">Users</button>
                        <button type="button" id="btnSearchTag" class="btn btn-info" onclick="switchSearch(\'tag\');">Tags</button>';
                        }
                        ?>
                    </div>
                    <span style="float:left;">
                        <?php
                        // Search by USERNAME
                        if ($_SESSION["loggedIn"] == true){ 
                        //tag search box
                        echo '<input type="text" id="searchtag" name="searchtag" placeholder="Search.." onkeyup="if(event.keyCode == 13){SearchForTag();}">';
                        //user search box
                        echo '<form class="">
                        <input type="text" id="search" name="search" autocomplete="off" placeholder="Search.." onkeyup="showResult(this.value)">
                        <div id="usersearch"></div>
                        </form>';
                        } 
                        ?>
                    </span>
                    <div class="btn-group pull-right" >
						<a href="ask.php" class="btn btn-info"> Ask a Question!</a>
                    <?php 
                    if ($_SESSION["loggedIn"] != true){
                        echo '<a href="login.php" class="btn btn-info" role="button"> Log in</a>';
                        echo '<a href="register.php" class="btn btn-info" role="button"> Register</a>';
                    }
                    else{
                        echo '<a href="login.php" class="btn btn-info" role="button"> Log out</a>';
                    }
                    ?>
                        <a href="help.php" class="btn btn-info"> Help</a>
                    </div>
	</div>
    <hr style="clear:both;">
    
    <?php
    if (isset($_SESSION["Upload"]) && $_SESSION["Upload"] != 0){ //print picture upload error
        echo "<div class='alert alert-warning text-center'><strong>" . $_SESSION["Upload"] . "</strong></div>";
        unset($_SESSION["Upload"]);
    }
    
    if(isset($_GET['QN'])) //if there is a get question, make that value the session for QNumber
        $_SESSION["QNumber"] = $_GET['QN'];
    ?>
    <div class="container">
    <?php
    $query = "SELECT * FROM QUESTIONS WHERE ID =".$_SESSION["QNumber"].";";
    $sqlresult = sqlcommand($query, "SELECT");
    $sqlresult = $sqlresult->fetch_assoc();
    $qTitle = $sqlresult["QUESTION_TITLE"];
    $qPhrase = $sqlresult["QUESTION_PHRASE"];
    $qTag = $sqlresult["TAG"];
    $qPoints = $sqlresult["POINTS"];
    $qDate = $sqlresult["DATE_ASKED"];
    $qAskerid = $sqlresult["ASKER_ID"];
    $answerID = $sqlresult["ANSWER_ID"];
    $frozen = $sqlresult["FROZEN"];
    $query = "SELECT * FROM USERS WHERE ID =" . $qAskerid . ";";
    $sqlresult = sqlcommand($query, "SELECT");
    $sqlresult = $sqlresult->fetch_assoc();
    $qAsker = $sqlresult["USERNAME"];
    $qkpoints = $sqlresult["KARMA_POINTS"];
    $qavatarchoice = $sqlresult["AVATAR"];
    $qemail =  $sqlresult["EMAIL"];
    if($qavatarchoice == 0){
        $picname = "profilePics/" . $qAskerid . '_' . $qAsker . '.';
        $picname = picext($picname);
    }
    else if($qavatarchoice == 1)
        $picname = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($qemail)));
    echo '<div class="col-sm-1" ><div class="col-sm-1 "><br>';
        if ($_SESSION["loggedIn"] == true){
            if (getvotes("Q", $_SESSION["QNumber"])==1)
                echo '<img id="voteupQ" src="upvoteActive.png" alt="active upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'Q\', '. $_SESSION["QNumber"] . ', '. $qAskerid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="voteupQ" src="upvote.png" alt="upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'Q\', '. $_SESSION["QNumber"] . ', '. $qAskerid . ', '. $_SESSION["UserID"]. ')">';
        }
    echo '<br><br><h4 id="qPoint" class="text-center">' . $qPoints . '</h4><br>';
        if ($_SESSION["loggedIn"] == true){
           if (getvotes("Q", $_SESSION["QNumber"])==2)
                echo '<img id="votedownQ" src="downvoteActive.png" alt="active downvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'Q\', '. $_SESSION["QNumber"] . ', '. $qAskerid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="votedownQ" src="downvote.png" alt="downvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'Q\', '. $_SESSION["QNumber"] . ', '. $qAskerid . ', '. $_SESSION["UserID"]. ')">';
        }
    echo '</div></div>';
    echo '<div class="col-sm-11">';
    echo '<h1>' . $qTitle . '</h1>';
    echo '<h3>' . $qPhrase . '</h3>';
    //display question picture;
    $questpic = "questPics/" . $_SESSION["QNumber"] . ".";
    $questpic = picext($questpic);
    if ($questpic != "profilePics/stock.png")
        echo '<img class="anspicture" alt="Picture" src="' . $questpic . '">';
        
    echo '<div class="media"><div class="media-body">';
    echo '<h5 class="text-right"><a href="profile.php?name=' . $qAsker . '"> ' . $qAsker . '</a><span class="badge" name="badge' . qAskerid .'">' . $qkpoints . '</span></h5>
    <h6 class="text-right">' . $qDate . '</h6>';
    //split tag string into array
    $tagArray = explode(" ", $qTag);
    echo '<div class="btn-group pull-right">';
    foreach ($tagArray as $tagelement){
    echo '<a class="btn btn-info" href="tagsearch.php?tag=' . $tagelement . '">' . $tagelement . '</a>';
    }
    echo '</div></div>
    <div class="media-right"> <img class="media-object" alt="Profile picture" style="width:70px; height:40px;" src="' . $picname . '"></div></div></div>';
    if ($_SESSION["UserID"] == 1){ // if user is admin, show freeze options
        echo '<div class="btn-group pull-right">';
        //freeze question
        if ($frozen == 0){  
            echo '<button id="freezeQuest" form="freeze" type="submit" name="freezeQuest" value="1" class="btn btn-info">FREEZE</button>';
        }
        else{
            echo '<button id="freezeQuest" form="freeze" type="submit" name="freezeQuest" value="0" class="btn btn-info">UNFREEZE</button>';
        }
        //edit question
        echo '<button id="editQuest" form="edit" data-toggle="modal" data-target="#editQ" type="button" name="editQuest" class="btn btn-info">EDIT</button>';
        //delete question
        echo '<button id="deleteQuest" type="button" data-toggle="modal" data-target="#deleteQ" name="deleteQuest" class="btn btn-info">DELETE</button>';
        echo '</div>';
    }
    
    echo "<h3>Answers</h3>";
    //check if there is a selected answer
        if ($answerID != '0'){ 
            $queryanswer = "SELECT * FROM ANSWERS WHERE ID =". $answerID . ";";
            $getanswer = sqlcommand($queryanswer, "SELECT");
            $getanswer = $getanswer->fetch_assoc();
            $aPoints = $getanswer["POINTS"];
            $correctanswerid = $getanswer["ID"];
            $correctanswererid = $getanswer["USER_ID"];
            echo "<div class='well' style='background-color:#66ff33'>";
            echo '<div class="col-sm-1"><div class="col-sm-1">';
        if ($_SESSION["loggedIn"] == true){
            if (getvotes("A", $answerID)==1)
                echo '<img id="voteupA'.$answerID.'" src="upvoteActive.png" alt="active upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'A\', '. $answerID . ', '. $correctanswererid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="voteupA'.$answerID.'" src="upvote.png" alt="upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'A\', '. $answerID . ', '. $correctanswererid . ', '. $_SESSION["UserID"]. ')">';
        }
        echo '<br><h4 id="aPoint'.$answerID.'" class="text-center">' . $aPoints . '</h4>';
        if ($_SESSION["loggedIn"] == true){
           if (getvotes("A", $answerID)==2)
                echo '<img id="votedownA'.$answerID.'" src="downvoteActive.png" alt="active downvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'A\', '. $answerID . ', '. $correctanswererid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="votedownA'.$answerID.'" src="downvote.png" alt="downvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'A\', '. $answerID . ', '. $correctanswererid . ', '. $_SESSION["UserID"]. ')">';
        }
            echo '</div></div>';
            $correctANS = $getanswer["ANSWER"];
            echo "<p>" . $correctANS . "</p>";
            //display question picture;
            $picname = "answerPics/" . $_SESSION["QNumber"] . "_" . $answerID  . ".";
            $picname = picext($picname);
            if ($picname != "profilePics/stock.png"){
                echo '<img alt="Picture" src="' . $picname . '">';
            }
            $correctdate = $getanswer["DATE_ANSWERED"];
            $queryanswer = "SELECT USERNAME, KARMA_POINTS, EMAIL, AVATAR FROM USERS WHERE ID =" . $correctanswererid.";";
            $result3 = sqlcommand($queryanswer, "SELECT");
            $result3 = $result3->fetch_assoc();
            $correctanswerer = $result3["USERNAME"];
            $kpoints = $result3["KARMA_POINTS"];
            if ($result3["AVATAR"] == 0){
                $picname = "profilePics/" . $correctanswererid . '_' . $correctanswerer . '.';
                $picname = picext($picname);
            }
            else if ($result3["AVATAR"] == 1){
                $picname = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($result3["EMAIL"])));
            }
            echo '<div class="media"><div class="media-body">';
            echo '<h5  class="text-right"><a href="profile.php?name=' . $correctanswerer . '"> ' . $correctanswerer . '</a><span class="badge" name="badge' . $correctanswererid . '">' . $kpoints . '</span></h5>';
            echo '<h6 class="text-right">' . $correctdate . '</h6>';
            echo '</div><div class="media-right"> <img class="media-object" alt="Profile Picture" style="width:70px; height:40px;" src="' . $picname . '">';
            echo '</div></div></div>';
        }
    
    //List answers
    //get total number of answers
    $query1 = "SELECT COUNT(*) AS ANSCOUNT FROM ANSWERS WHERE ID <> " . $answerID . " AND QUEST_ID =".$_SESSION["QNumber"].";";
    $countresult = sqlcommand($query1, "SELECT");
    if ($countresult != "false"){
        $countrow = $countresult->fetch_assoc();
        $anscount = $countrow['ANSCOUNT'];
        $numpages = $anscount / 5;
        $numpages = ceil($numpages);
    }
    
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if ($page > $numpages)
            redirect("question.php");
    }
    else
        $page = 1;
        
    //Get answers
    $query = "SELECT * FROM ANSWERS WHERE ID <> " . $answerID . " AND QUEST_ID =".$_SESSION["QNumber"]." ORDER BY POINTS DESC, DATE_ANSWERED ASC LIMIT " . 5*($page-1) .", " . 5 . ";";
    $result = sqlcommand($query, "SELECT");
    if ($result == false && $answerID == 0)
        echo "No answers yet. Check back again soon!\n";
    if ($result != false){//display answers
        while($row = $result->fetch_assoc()) {
            $answerlistid = $row["ID"];
            $aPoints = $row["POINTS"];
            $answererid = $row["USER_ID"];
            echo "<div class='well' >";
            echo '<div class="col-sm-1" ><div class="col-sm-1 ">';
        if ($_SESSION["loggedIn"] == true){
            if (getvotes("A", $answerlistid)==1)
                echo '<img id="voteupA'.$answerlistid.'" src="upvoteActive.png" alt="active upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'A\', '. $answerlistid . ', '. $answererid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="voteupA'.$answerlistid.'" src="upvote.png" alt="upvote" style="width:25px; height:25px; cursor:pointer;" onclick="vote(1, \'A\', '. $answerlistid . ', '. $answererid . ', '. $_SESSION["UserID"]. ')">';
        }
        echo '<br><h4 id="aPoint'.$answerlistid.'" class="text-center">' . $aPoints . '</h4>';
        if ($_SESSION["loggedIn"] == true){
           if (getvotes("A", $answerlistid)==2)
                echo '<img id="votedownA'.$answerlistid.'" alt="Active downvote" src="downvoteActive.png" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'A\', '. $answerlistid . ', '. $answererid . ', '. $_SESSION["UserID"]. ')">';
            else
                echo '<img id="votedownA'.$answerlistid.'" alt="downvote" src="downvote.png" style="width:25px; height:25px; cursor:pointer;" onclick="vote(2, \'A\', '. $answerlistid . ', '. $answererid . ', '. $_SESSION["UserID"]. ')">';
        }
            echo '</div></div>';
            $theanswer = $row["ANSWER"];
            echo $theanswer; //style='background-color:#66ff33' for right answer
            //display answer picture;
            $anspic = "answerPics/" . $_SESSION["QNumber"] . "_" . $answerlistid  . ".";
            $anspic = picext($anspic);
            if ($anspic != "profilePics/stock.png")
                echo '<img class="anspicture" alt="Picture" src="' . $anspic . '">';
            
            $query = "SELECT USERNAME, KARMA_POINTS, EMAIL, AVATAR FROM USERS WHERE ID=" . $answererid.";";
            $result2 = sqlcommand($query, "SELECT");
            $result2 = $result2->fetch_assoc();
            $answerer = $result2["USERNAME"];
            $akpoints = $result2["KARMA_POINTS"];
            if ($result2["AVATAR"] == 0){
                $picname = "profilePics/" . $answererid . '_' . $answerer . '.';
                $picname = picext($picname);
            }
            else if ($result2["AVATAR"] == 1){
                $picname = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($result2["EMAIL"])));
            }
            echo '<div class="media"><div class="media-body">';
            //if question hasn't been answered or if userID isn't the person who asked the question, make the button invisible
            if ($answerID == '0' and $_SESSION["userName"] == $qAsker and $frozen == 0){
                echo '<button id="rightAnswer" type="submit" name="AnswerSubmit" value="'.$answerlistid.'" form="correct" class="btn btn-info" style="float:left;" >THIS IS THE ANSWER!</button>';
            }
            echo '<h5  class="text-right"><a href="profile.php?name=' .  $answerer . '"> ' . $answerer . '</a><span class="badge" name="badge'. $answererid . '">' . $akpoints . '</span></h5>';
            echo '<h6 class="text-right">' . $row["DATE_ANSWERED"] . '</h6>';
            echo '</div><div class="media-right"> <img class="media-object" alt="Profile Picture" style="width:70px; height:40px;" src="' . $picname . '">';
            echo '</div></div></div>';
        }
     //insert pagination
        if (isset($numpages)){
            echo '<div class="text-center">
            <ul id="pagin" class="center pagination">';
            if ($page != 1)
            echo '<li id="firstpagin"><a href="question.php?page=1">First</a></li>';
            if ($page > 3){
                echo '<li class="disabled"><a href="">...</a></li>';
            }
            for($i = max(1, $page - 2); $i <= min($page + 2, $numpages); $i++){
                if ($i != $page)
                    echo '<li><a href="question.php?page=' . $i .'">'. $i .'</a></li>';
                else
                    echo '<li class="page-item active"><a href="">'. $i .'</a></li>';
            }
            if ($i-1 < $numpages)
                echo '<li class="disabled"><a href="">...</a></li>';
            if ($page != $numpages)
            echo '<li><a href="question.php?page='.$numpages.'">Last</a></li>';
            echo '</ul></div>';
        }
    }   
    ?>
    <!-- Edit Question Modal -->
    <div id="editQ" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Question</h4>
                </div>
            <div class="modal-body">
            <form id="edit" action="editQuest.php" method="POST">
                <div class="form-group">
            <label>Title:</label>
            <input type="text" name="newTitle" pattern=".{5,60}" required title="Your title needs to be between 5-60 characters" class="form-control" <?php echo 'value= "' . $qTitle . '"';?>>
        </div>
        <div class="form-group">
            <label>Question:</label>
            <textarea name="newQuestion" id="questiontextarea" maxlength="500"  required title="Your question needs to be between 5-500 characters" class="form-control" rows="5" ><?php echo $qPhrase;?></textarea>
        </div>
        <div class="form-group">
            <label>Tags:</label>
            <input type="text" name="newTag" pattern=".{2,100}" required title="You must have at least 1 tag between 2-100 characters" class="form-control" <?php echo 'value= "' . $qTag . '"';?>>
        </div>
        </form>
        </div>
            <div class="modal-footer">
                <button class="btn btn-info" form="edit" type="button" name="submit" onclick="CheckLength2();">Accept Changes!</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Delete Question Modal -->
    <div id="deleteQ" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to delete this question?</h4>
                </div>
            <div class="modal-footer">
                <button class="btn btn-info" form="delete" type="submit" name="submit">Yes, delete!</button>
            </div>
            </div>
        </div>
    </div>
    <form id="freeze" action="freeze.php" method="POST"></form>
    <form id="delete" action="deleteQuest.php" method="POST"></form>
    <form id="correct" action="correctans.php" method="POST"></form>
        
    <!-- New Answer form -->
    <form id="newAnswer" action="insertanswer.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="text-center alert alert-warning" style="display:none;" id="lengthalert"> </div>
            <label for="Answer">Your Answer:</label>
            <textarea name="Answer" maxlength="500" required title="Your answer needs to be between 2-500 characters" id="Answer" class="form-control"></textarea>
        </div>
        <strong>Select image to upload:</strong> <input type="file" name="fileToUpload" id="fileToUpload">
    <button type="button" class="btn btn-primary center-block" onclick="CheckLength();">Submit Answer!</button><br><br><br>
	</form>
    </div>
    
    <?php 
	if ($_SESSION["loggedIn"] != true)
	{
        echo '<script type="text/javascript"> document.getElementById("newAnswer").style.display="none"; </script>';
		echo "<h3 class='text-center'>Unfortunately, you have to be logged in to answer questions. I know, bummer! Please "; 
		echo '<a href="./login.php">login here!</a></h3>';
	}
    else if ($frozen == 1){
        echo '<script type="text/javascript"> document.getElementById("newAnswer").style.display="none"; document.getElementById("rightAnswer").style.display="none";</script>';
		echo "<h3 class='text-center'>This question has been frozen by the administrator</h3>"; 
    }        
    ?>
    
</body>
</html>