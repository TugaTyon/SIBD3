<html>
  <body>
    <h3>Registered Patients</h3>
      <?php
        try
        {
          $host = 'db.ist.utl.pt';
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
        echo($_REQUEST['patient_name']);
        $a = 10;
        $sql = "SELECT * FROM Patient WHERE name= '" . $_REQUEST['patient_name'] . "'";
        $result = $connection->query($sql);

        if ($result == FALSE)
        {
          $info = $connection->errorInfo();
          echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
          exit();
        }
        elseif ( !mysql_num_rows($result ))
        {
          echo("<p>We found no Patients with such name. Would you like to add a new entry?</p>");
          /** CODE TO INSERT NEW PATIENT IN THE DATABASE */
        }
        else
        {
          echo("<table border=\"1\">");
          echo("<tr><td>ID</td><td>Name</td>
                <td>Birthday</td><td>Address</td></tr>");
          foreach($result as $row)
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

      ?>
    <p>Names: <?php echo($_REQUEST['patient_name']); ?> </p>
  </body>
</html>
