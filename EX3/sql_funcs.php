<?php

function new_connection(&$connection)
{
    $host = 'db.tecnico.ulisboa.pt';
    $user = 'ist173065';
    $pass = 'wsfv4254';
    $dsn = "mysql:host=$host;dbname=$user";

    try{
        
        $connection = new PDO($dsn, $user, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }
    catch(PDOException $exception)
    {
        echo("<p>Error!! Info: ");
        echo($exception->getMessage());
        echo("</p>");
        exit();
    }

}

function sql_safe_query($connection, $sql, Array $vals = [] )
{
  $stmt = $connection->prepare($sql);

  foreach($vals as $key => &$value)
    {

        $stmt->bindParam($key,$value);
 
    }
   
   try{
        $stmt->execute();

    }
    catch(PDOException $exception)
    {
        echo("<p>Error!! Info: ");
        echo($exception->getMessage());
        echo("</p>");
        exit();
    }

  return $stmt  ;
}

?>
