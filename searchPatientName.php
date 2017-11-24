<html>
  <body>
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
        $sql = "SELECT * FROM Patient WHERE name= '" . $_REQUEST['patient_name'] . "'";
        $stmt= $connection->prepare($sql);
        $stmt-> execute();
        $row_num = $stmt->rowCount();

        //$row_count = $result->row_Count();


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
          //$connection = NULL;
        }
        else
        {
          echo("<h3>Appointment Scheduller</h3>");
          echo("<p>We found no Patients with such name. Would you like to add a new entry?</p>");
          //echo("<p>Please insert the Patient Name: <input type="text" name="patient_name"/></p>");
           /*METER OUTRA PAGINA (form)*/
        }

       ?>
  </body>
</html>
