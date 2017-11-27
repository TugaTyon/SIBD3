<html>
    <head>
      <title>Available Devices</title>
  </head>
  <body>
      <h3>Available Devices: <?php echo($_REQUEST['manuf']); ?></h3>

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
      WHERE snum = serialnum AND manuf = manufacturer AND manuf = '".$_REQUEST['manuf']."' GROUP BY serialnum";
      $stmt= $connection->prepare($sql);
      $stmt-> execute();

      date_default_timezone_set('Europe/Lisbon');
      $currentDate = date('Y-m-d H:i:s');

      echo ("<h4>Choose a Device for Replacement</h4>");
      echo("<table border=\"1\">");
      echo("<tr><td>ID</td><td>Model</td>
            <td>Manufacturer</td></tr>");

      foreach($stmt as $row)
      {
        if (!($currentDate < $row['end'])) {//TIRAR COMENTARIO DEPOIS DE TABELAS UPDATED!!!!!!!!!!!
          echo("<tr><td>");
          echo($row['snum']);
          echo("</td><td>");
          echo($row['model']);
          echo("</td><td>");
          echo($row['manufacturer']);
          echo("</td><td>");
          ?>
          <form name="form" method="POST" action="confirmReplacment.php">
            <input value="<?php echo($row['manufacturer']);?>" type="hidden" name="manuf">
            <input type="submit"  value="Choose">
           </form>
          <?php
          echo("</td></tr>");
        }
      }
      echo("</table>");

       ?>

  </body>
</html>
