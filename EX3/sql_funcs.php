<?php

function new_connection(&$connection)
{
    $host = 'db.tecnico.ulisboa.pt';
    $user = 'ist173065';
    $pass = 'wsfv4254';
    $dsn = "mysql:host=$host;dbname=$user";
    echo("<p>Attempting to connect to DB");
    echo("</p>");

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

function sql_secure_query($connection, $sql, Array $vals = [] )
{
  $stmt = $connection->prepare($sql);

  foreach($vals as $key => &$value)
    {
        echo("<p>$key : $value</p>");
        $stmt->bindParam($key,$value);
 
    }
   
   try{
        if ($stmt->execute() == FALSE)
        {
            $info =  $connection->errorInfo();
            echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
            exit();
        }
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
