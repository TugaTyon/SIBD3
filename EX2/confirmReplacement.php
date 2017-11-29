<?php
  require_once('sql_funcs.php');
  session_start();
?>
<html>
    <head>
      <title>Replacement Confirmed</title>
  </head>
  <body>
      <h3>Replacement Confirmed!</h3>

      <?php
      $connection = null;
      new_connection($connection);

      date_default_timezone_set('Europe/Lisbon');
      $currentDate = date('Y-m-d H:i:s');
      $newCurrentDate = date("Y-m-d H:i:s", time() + 1);
      $newEnd = date('2099-01-01 14:55:24');


      $sql1 = "INSERT INTO Period (start, `end`) VALUES (:oldstart ,:currentDate)";
      $stmt1=sql_safe_query($connection, $sql1, Array(":oldstart" => $_REQUEST['oldstart'], ":currentDate" => $currentDate));

      $sql2 = "INSERT INTO Period (start, `end`) VALUES (:newCurrentDate, :newEnd)";
      $stmt2=sql_safe_query($connection, $sql2, Array(":newCurrentDate" => $newCurrentDate, ":newEnd" => $newEnd));

      $sql3 = "UPDATE Wears SET start = :oldstart , `end` = :currentDate WHERE start = :oldstart1
      AND patient = :patient_id AND snum = :snum_replace AND manuf = :manufacturer ";
      $stmt3=sql_safe_query($connection, $sql3, Array(":oldstart" => $_REQUEST['oldstart'], ":currentDate" => $currentDate, ":oldstart1" => $_REQUEST['oldstart'],
      ":patient_id" => $_REQUEST['patient_id'], ":snum_replace" => $_REQUEST['snum_replace'], ":manufacturer" => $_REQUEST['manufacturer']));

      $sql4 = "INSERT INTO Wears (start, `end`, patient, snum, manuf) VALUES (:newCurrentDate, :newEnd,:patient_id,:serialnum ,:manufacturer )";
      $stmt4=sql_safe_query($connection, $sql4, Array(":newCurrentDate" => $newCurrentDate, ":newEnd" => $newEnd, ":patient_id" => $_REQUEST['patient_id'],
       ":serialnum" => $_REQUEST['serialnum'], ":manufacturer" => $_REQUEST['manufacturer']));

       ?>
       <form action="appointment.php" method="post">
         <p><input type="submit" value="Homepage"/></p>
       </form>
  </body>

</html>
