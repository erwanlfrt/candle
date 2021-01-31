<?php 
  session_start();
  //prevent CSRF with a token.
  $token = uniqid(rand(), true); //generate a token
  $_SESSION['token'] = $token;  //add token to session
  $_SESSION['token_time'] = time(); //add the token's date of creation.

?>
<?php 
    //database connection
    require_once 'Model/databaseConnection.php';
    use \Model\DatabaseConnection;
    $db = DatabaseConnection::getDatabaseConnection(); 
    $id = $_GET['id'];

    //get information about candle
    $qry = mysqli_query($db,"select nom_bougie, id_livre, id_collection, statut_bougie from bougie where id_bougie='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $name =  $data["nom_bougie"];
    $id_livre = $data["id_livre"];
    $id_collection = $data["id_collection"];
    $status = $data["statut_bougie"];

    //get associated events 
    $qry = mysqli_query($db, "SELECT * from events where id_bougie=".$id.";");
    $sql = "SELECT * from events where id_bougie=".$id.";";
    $listEvents = $db->query($sql);
    
    $namesEvents = [];
    //find names of associated events
    while($row = $listEvents->fetch_assoc()){
        $qry = mysqli_query($db, "SELECT name from event where id=".$row['id_event']);
        array_push($namesEvents, mysqli_fetch_array($qry)["name"]);
    }

    //get title of associated book
    $qry = mysqli_query($db,"select titre from livre where id_livre='$id_livre';"); // select query
    $data2 = mysqli_fetch_array($qry); // fetch data
    $title =  $data2["titre"];

    //get name of associated collection
    $qry = mysqli_query($db,"select nom_collection from collection where id_collection='$id_collection';"); // select query
    $data3 = mysqli_fetch_array($qry); // fetch data
    $collection = $data3["nom_collection"];

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>TP PHP</title>
        <link rel="stylesheet" href="View/style/edit.css">
    </head>
    <body>
        <div id="menuBar">
            <p id="logo">g</p>
            <p><a href="/?action=home">Accueil</a></p>
        </div>
        <?php 
        if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){
      ?>
        <div id="main">
            <div id="divForm">
                <form action="?action=edit&table=candle&control&id=<?php echo $id; ?>" method="post">
                    <p>Modifier une bougie</p>
                    <p><?php echo sizeof($namesEvents);?></p>
                    <div>
                            <div id="textFieldDiv">
                                <input class="textField" type="text" id="name" name="name" value=<?php echo $name; ?>>
                                <input class="textField" type="text" id="title" name="title" value=<?php echo $title; ?>>
                                <input class="textField" type="text" id="collection" name="collection" value=<?php echo $collection; ?>>
                            </div>
                            <div>
                                <p>Candle status :</p>
                                <div class="radioLine">
                                    <input <?php if($status === 'validée'){ echo 'checked'; } ?> type="radio" id="candleStatus1" name="candleStatus" value="validée">
                                    <label for="candleStatus1">validée</label>
                                </div>
                                
                                <div class="radioLine">
                                    <input <?php if($status === 'neutre'){ echo 'checked'; } ?> type="radio" id="candleStatus2" name="candleStatus" value="neutre">
                                    <label for="candleStatus2">neutre</label>
                                </div>
                                <div class="radioLine">
                                    <input <?php if($status === 'rejetée'){ echo 'checked'; } ?> type="radio" id="candleStatus3" name="candleStatus" value="rejetée">
                                    <label for="candleStatus3">rejetée</label>
                                </div>
                            </div>
                    </div>
                    <div>

                        <p>Associate event list</p>
                        <div id="listEvents" >
                            <?php 
                                //add an input for each already associated event
                                for($j = 0; $j<sizeof($namesEvents); $j++){
                                    ?><input type="text" name="eventProp[]" readonly value=<?php echo $namesEvents[$j]; ?> />
                                <?php
                                }
                        
                            ?>
                        </div>
                        <select id="selectEvent" name="selectEvent" onchange="addEvent(this);">
                            <option value="" disabled selected>Sélectionner un event</option> 
                            <?php 
                                $sql = "SELECT id, name FROM event";
                                $result = $db->query($sql);
                                //add an option for each event
                                while($row = $result->fetch_assoc()) {
                                    ?><option value=<?php echo $row['id'];?>><?php echo $row['name'];?></option><?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="button">
                        <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
                        <input  id="submit" type="submit" name="update" value="Update">
                    </div>
                    <div>
                </form>
            </div>
        </div>
        <?php
        }
        else{
          ?>
          <p>Vous n'êtes pas autorisé à accéder à cette page</p>
          <?php
        } ?>
    </body>

    <script>
        var divEvents = document.getElementById("listEvents");

        //for each already associated event, add a listener to disappear on click
        for (var i = 0; i < divEvents.children.length; i++) {
            divEvents.children[i].addEventListener('click', (event) =>{disappear(event)});
        }

        /**
         * add an event to candle into the div which contains selected events.
         * @param sel select html element
         */
        function addEvent(sel){
            var divEvents = document.getElementById("listEvents");
            var selectedEvents = [];
            //list selected events
            for (var i = 0; i < divEvents.children.length; i++) {
                selectedEvents.push(divEvents.children[i].value);
                divEvents.children[i].addEventListener('click', (event) =>{disappear(event)});
            }
            //check if event not already into selected events and if it has a correct value
            if(!selectedEvents.includes(sel.options[sel.selectedIndex].innerHTML) && sel.options[sel.selectedIndex].innerHTML !== "Sélectionner un event"){
                //create an input with the event name as value
                var input = document.createElement("input");
                input.value = sel.options[sel.selectedIndex].innerHTML;
                input.name = "eventProp[]";
                input.type = "text";
                input.addEventListener('click', (event) =>{disappear(event)});
                input.readOnly = true;
                divEvents.appendChild(input);
            }
            
        
        }

        /**
         * make an element disappear
         * @param e event
         */
        function disappear(e){
            if(e){
                e.currentTarget.parentNode.removeChild(e.currentTarget);
            } 
        }     
    </script>
</html>
