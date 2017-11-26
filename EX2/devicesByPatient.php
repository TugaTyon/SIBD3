<html>
    <head>
      <title>Devices by Patient</title>
  </head>
  <body>
      <h3>Patient: <?php echo($_REQUEST['patient_name']); ?></h3>
      <h4>Devices</h4>
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
      $sql = "SELECT * FROM  Wears , Device
      WHERE patient = ".$_REQUEST['patient_id']." AND snum = serialnum AND manuf = manufacturer ORDER BY 'end'";
      $stmt= $connection->prepare($sql);
      $stmt-> execute();

      $currentDate = new DateTime("now");

      echo("<table border=\"1\">");
      echo("<tr><td>ID</td><td>Model</td>
            <td>Manufacturer</td></tr>");

      foreach($stmt as $row)
      {
        echo("<tr><td>");
        if (!($currentDate < $row['end'])) {
          echo($row['snum']);   //If Device no longer in use
        }else {
          echo('<a href="">'.$row['snum'].'</a>'); //If Device is in use and highlighted
          echo ("<input type="button" value="Replace" onClick="location='deviceReplacement.php'"/>");
        }
        echo("</td><td>");
        echo($row['model']);
        echo("</td><td>");
        echo($row['manufacturer']);
        echo("</td><tr>");

      }
      echo("</table>");

       ?>


  </body>

</html>
