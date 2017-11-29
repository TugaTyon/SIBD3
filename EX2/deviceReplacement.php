<?php
  require_once('sql_funcs.php');
  session_start();
?>

<html>
    <head>
      <title>Available Devices</title>
  </head>
  <body>
      <h3>Available Devices: <?php echo($_REQUEST['manuf']); ?></h3>

      <?php
      $connection = null;
      new_connection($connection);

      $sql = "SELECT * FROM  Wears , Device
      WHERE snum = serialnum AND manuf = manufacturer AND manuf = :manufacturer GROUP BY serialnum";
      $stmt=sql_safe_query($connection, $sql, Array(":manufacturer" => $_REQUEST['manuf']));

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
          <form name="form" method="POST" action="confirmReplacement.php">
            <input value="<?php echo($row['manufacturer']);?>" type="hidden" name="manufacturer">
            <input value="<?php echo($row['snum']);?>" type="hidden" name="serialnum">
            <input value="<?php echo($_REQUEST['oldstart']);?>" type="hidden" name="oldstart">
            <input value="<?php echo($_REQUEST['patient_id']);?>" type="hidden" name="patient_id">
            <input value="<?php echo($_REQUEST['snum_replace']);?>" type="hidden" name="snum_replace">
            <input type="submit"  value="Choose">
           </form>
          <?php
          echo("</td></tr>");
        }
      }
      echo("</table>");

       ?>
       <form action="devicesByPatient.php" method="post">
         <p><input type="submit" value="Back"/></p>
       </form>
       <form action="appointment.php" method="post">
         <p><input type="submit" value="Homepage"/></p>
       </form>
  </body>
</html>
