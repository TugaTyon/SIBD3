<?php

function new_connection(&$connection)
{
    $host = 'db.tecnico.ulisboa.pt';
    $user = 'ist173065';
    $pass = 'wsfv4254';
    $dsn = "mysql:host=$host;dbname=$user";
    

  try{
      $connection = new PDO($dsn, $user, $pass);
  }
  catch(PDOException $exception)
  {
      echo("<p>Error: ");
      echo($exception->getMessage());
      echo("</p>");
      exit();
  }

}

function sql_secure_query($connection, $sql, Array $vals = [] )
{
  $stmt = $connection->prepare($sql);

  foreach($vals as $key => &$value)
       $stmt->bindParam($key ,  $value);

   if ($stmt->execute() == FALSE)
   {
       $info =  $connection->errorInfo();
       echo("<div class=\"alert alert-danger\"> <b>Error: </b>");
       echo($stmt->errorInfo()[2]);
       echo("</div>");
       exit();
   }

  return $stmt  ;
}

?>
