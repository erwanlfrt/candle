<?php
  require_once 'Model/databaseConnection.php';
  use \Model\DatabaseConnection;
  $db = DatabaseConnection::getDatabaseConnection(); 

  //get list of events
  $sql = "SELECT id, name FROM event";
  $result = $db->query($sql);
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
        if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){ //webpage not available for non-admin user
      ?>
    <div id="main">
    <form action="?action=add&table=candle&control" method="post">
      <div>
          <input class="textField" type="text" id="name" name="name" placeholder="name">
          <input class="textField" type="text" id="title" name="title" placeholder="title">
          <input class="textField" type="text" id="collection" name="collection" placeholder="collection">
          <div>
              <p>Candle status :</p>
              <input type="radio" id="candleStatus1" name="candleStatus" value="validée">
              <label for="candleStatus1">validée</label>

              <input type="radio" id="candleStatus2" name="candleStatus" value="neutre">
              <label for="candleStatus2">neutre</label>

              <input type="radio" id="candleStatus3" name="candleStatus" value="rejetée">
              <label for="candleStatus3">rejetée</label>
          </div>
      </div>
      <div>

        
        <p>Associer à des events</p>
        <p>(Pour supprimer un event sélectionné, cliquez dessus)</p>
        <div id="listEvents" >

        </div>
        <select id="selectEvent" name="selectEvent" onchange="addEvent(this);">
          <option value="" disabled selected>Sélectionner un event</option> 
          <?php 
              //add an option for each event
              while($row = $result->fetch_assoc()) {
                ?><option value=<?php echo $row['id'];?>><?php echo $row['name'];?></option><?php
              }
          ?>
        </select>

      </div>
      <div class="button">
         <input type="submit" id='submit' value='add candle' >
      </div>
      <div>
      <?php
          if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1 || $err==2)
            {
                  echo "<p style='color:red'>candle already exist</p>";
            }
            elseif($err==3){
                  echo "<p style='color:red'>Invalid form</p>";
            }
            elseif($err==4){
                  echo "<p style='color:red'>Title unkown</p>";
            } 
            elseif($err==5){
              echo "<p style='color:red'>Collection unknown</p>";
            } 
          }
      ?>
    </div>
  </form>
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
      }
      //check if event not already into selected events and if it has a correct value
      if(!selectedEvents.includes(sel.options[sel.selectedIndex].innerHTML) && sel.options[sel.selectedIndex].innerHTML !== "Sélectionner un event"){
        //create an input with the event name as value
        var input = document.createElement("input");
        input.value = sel.options[sel.selectedIndex].innerHTML;
        input.name = "eventProp[]";
        input.type = "text";
        //add an onclick listener, make the element disappear if we click on it.
        input.addEventListener('click', (event) =>{disappear(event)});
        input.readOnly = true;
        //add new event to list of selected events.
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