<?php
  require_once('sql_funcs.php');
  session_start();
?>
<html>
  <body>
    <h3>Registerd Patients</h3>
    <?php
      $connection = null;
      new_connection($connection);

      $aux_null=null;
      $sql = "INSERT INTO Patient (number, name, birthday, address) VALUES (:number, :patient_name, :patient_birth,:patient_address)";
      $stmt=sql_safe_query($connection, $sql, Array(":number" => $aux_null, ":patient_name" => $_REQUEST['patient_name'],
                                                          ":patient_birth" => $_REQUEST['patient_birth'],
                                                          ":patient_address" => $_REQUEST['patient_address']));
     ?>
    <p>Name: <?php echo($_REQUEST['patient_name']); ?> </p>
    <p>Birthday: <?php echo($_REQUEST['patient_birth']); ?> </p>
    <p>Address: <?php echo($_REQUEST['patient_address']); ?> </p>
    
    <form action="appointment.php" method="post">
      <p><input type="submit" value="Homepage"/></p>
    </form>
  </body>
</html>
