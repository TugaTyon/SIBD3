<html>
  <body>
    <h3>Registerd Patients</h3>
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

      $sql = "INSERT INTO ist173065.`Patient` (number, name, birthday, address) VALUES (null, '" .$_REQUEST['patient_name']. "', '" .$_REQUEST['patient_birth']. "','" .$_REQUEST['patient_address']. "')";
      $stmt= $connection->prepare($sql);
      $stmt-> execute();
     ?>
    <p>Names: <?php echo($_REQUEST['patient_name']); ?> </p>
    <p>Names: <?php echo($_REQUEST['patient_birth']); ?> </p>
    <p>Names: <?php echo($_REQUEST['patient_address']); ?> </p>
  </body>
</html>
