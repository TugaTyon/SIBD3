<?php
  require_once('sql_funcs.php');
  session_start();
?>
<html>
  <body>
      <?php
        $connection = null;
        new_connection($connection);

        $sql = "SELECT * FROM Patient WHERE name= :patient_name";
        $stmt=sql_safe_query($connection, $sql, Array(":patient_name" => $_REQUEST['patient_name']));
        $row_num = $stmt->rowCount();

        if ($stmt == FALSE)
        {
          $info = $connection->errorInfo();
          echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
          exit();
        }

        if ( $row_num > 0 )
        {
          echo ("<h3>Registered Patients</h3>");
          echo("<table border=\"1\">");
          echo("<tr><td>ID</td><td>Name</td>
                <td>Birthday</td><td>Address</td></tr>");

          foreach($stmt as $row)
          {
            echo("<tr><td>");
            echo($row['number']);
            echo("</td><td>");
            echo($row['name']);
            echo("</td><td>");
            echo($row['birthday']);
            echo("</td><td>");
            echo($row['address']);
            echo("</td></tr>");
          }
          echo("</table>");
          $connection = NULL;
          $stmt = NULL;
        }
        else
        {
          echo("<h3>Appointment Scheduller</h3>");
          echo("<p>We found no Patients with such name!</p>");
          ?>
        <form action="insert.php" method="post">
          <p>Please insert the Patient Name: <input type="text" name="patient_name"/></p>
          <p>Please insert the Patient Birthday(year-month-day): <input type="text" name="patient_birth"/></p>
          <p>Please insert the Patient Address: <input type="text" name="patient_address"/></p>
          <p><input type="submit" value="Submit"/></p>
        </form>
           <?php
        }

       ?>
       <form action="appointment.php" method="post">
         <p><input type="submit" value="Homepage"/></p>
       </form>
  </body>
</html>
