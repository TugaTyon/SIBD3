<html>
    <head>
      <title>Replacement Confirmed</title>
  </head>
  <body>
      <h3>Replacement Confirmed</h3>

      <?php
      try
      {
        $host = 'db.tecnico.ulisboa.pt';
        $user = 'ist173065';
        $pass = 'wsfv4254';
        $dsn = "mysql:host=$host;dbname=$user";
        $connection = new PDO($dsn, $user, $pass);
      }
        catch(PDOException $exception)
      {
        echo("<p>Error: ");
        echo($exception->getMessage());
        echo("</p>");
        exit();
      }
      date_default_timezone_set('Europe/Lisbon');
      $seconds = 1;
      $currentDate = date('Y-m-d H:i:s');
      $newCurrentDate = date("Y-m-d H:i:s", time() + 1);
      $newEnd = date('2099-01-01 14:55:24');


        echo ("<p>Serial number para apagar: '".$_REQUEST['snum_replace']."' OLD_Start:  '".$_REQUEST['oldstart']."'</p>");
      //TESTAR EM METER STMT TODOS IGUAIS!!!!
      $sql1 = "INSERT INTO Period (start, `end`) VALUES ('".$_REQUEST['oldstart']."', '".$currentDate."')";
      $stmt1= $connection->prepare($sql1);
      $stmt1-> execute();
      $sql2 = "INSERT INTO Period (start, `end`) VALUES ('".$newCurrentDate."', '".$newEnd."')";
      $stmt2= $connection->prepare($sql2);
      $stmt2-> execute();
      $sql = "UPDATE Wears SET start = '".$_REQUEST['oldstart']."', `end` = '".$currentDate."' WHERE start = '".$_REQUEST['oldstart']."'  AND patient = '".$_REQUEST['patient_id']."' AND snum = '".$_REQUEST['snum_replace']."' AND manuf = '".$_REQUEST['manufacturer']."' ";
      $stmt3= $connection->prepare($sql);
      $stmt3-> execute();
      /*$sql = "INSERT INTO Wears (start, `end`, patient, snum, manuf) VALUES ('".$newCurrentDate."', '".$newEnd."','".$_REQUEST['patient_id']."','".$_REQUEST['serialnum']."','".$_REQUEST['manufacturer']."' )";
      $stmt3= $connection->prepare($sql);
      $stmt3-> execute();*/
       ?>

  </body>

</html>
