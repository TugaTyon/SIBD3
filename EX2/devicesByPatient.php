<?php
  require_once('sql_funcs.php');
  session_start();
?>


<html>
    <head>
      <title>Devices by Patient</title>
  </head>
  <body>
      <h3>Patient: <?php echo($_REQUEST['patient_name']); ?></h3>
      <h4>Devices</h4>
      <?php
      $connection = null;
      new_connection($connection);

      $sql = "SELECT * FROM  Wears , Device
      WHERE patient = :patient_id AND snum = serialnum AND manuf = manufacturer ORDER BY `end` DESC";
      $stmt=sql_safe_query($connection, $sql, Array(":patient_id" => $_REQUEST['patient_id']));

      date_default_timezone_set('Europe/Lisbon');
      $currentDate = date('Y-m-d H:i:s');

      echo("<table border=\"1\">");
      echo("<tr><td>ID</td><td>Model</td>
            <td>Manufacturer</td></tr>");

      foreach($stmt as $row)
      {
        echo("<tr><td>");
        //highlighted ID
        if (($currentDate > $row['end'])) {
          echo($row['snum']);   //If Device no longer in use
        }else {
          echo('<a href="">'.$row['snum'].'</a>'); //If Device is in use -> highlighted
        }
        echo("</td><td>");
        echo($row['model']);
        echo("</td><td>");
        echo($row['manufacturer']);

        //Create Button per line of Current Device
        if (($currentDate > $row['end'])) {
          echo("</td></tr>");   //If Device no longer in use
        }else {//If Device is in use -> button (Form)
          echo ("<td>");
          ?>
          <form name="form" method="POST" action="deviceReplacement.php">
            <input value="<?php echo($row['manufacturer']);?>" type="hidden" name="manuf">
            <input value="<?php echo($_REQUEST['patient_id']);?>" type="hidden" name="patient_id">
            <input value="<?php echo($row['snum']);?>" type="hidden" name="snum_replace">
            <input value="<?php echo($row['start']);?>" type="hidden" name="oldstart">
            <input type="submit"  value="Replace">
           </form>
          <?php
          echo ("</td></tr>");
        }
      }
      echo("</table>");
      $connection = NULL;
      $stmt = NULL;
       ?>
       <form action="appointment.php" method="post">
         <p><input type="submit" value="Homepage"/></p>
       </form>
  </body>
</html>
