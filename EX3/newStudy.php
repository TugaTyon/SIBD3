<html>
    <head>
      <title>Creating a new study</title>
    </head>
  <body>
  <h3>Inserting into DB</h3>
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


        foreach ($_REQUEST as $exam_info => $value)
        {
            echo("<p>$exame_info = $value</p>");
        }

        try
        {
/*
            $sql = "INSERT INTO ist173065.`Request` (`number`, `patient_id`, `doctor_id`, `date`) VALUES (null, '" . $_REQUEST['patient_id'] . "' , '" . $_REQUEST['doctor_id'] . "' , NOW() )";
*/
            
            $patient_ID =  $_REQUEST['patient_id'];
            $doctor_ID = $_REQUEST['doctor_id'];
            $date = date('Y-m-d H:i:s');

            $stmt= $connection->prepare("INSERT INTO ist173065.`Request` (`patient_id`, `doctor_id`, `date`) VALUES (:patient_ID, :doctor_ID, :`date`)");

            
            if($stmt == false){
                echo("<p>prepare returned FALSE");
                echo("</p>");   
            }

            $stmt->bindParam(':patient_ID', $patient_ID);
            $stmt->bindParam(':doctor_ID', $doctor_ID);
            $stmt->bindParam(':date', $date);



/*
            $account_number = $_REQUEST['account_number'];
            $branch_name = $_REQUEST['branch_name'];
            $balance = $_REQUEST['balance'];
            $stmt = $connection->prepare("INSERT INTO account
            VALUES (:account_number, :branch_name, :balance)");
            $stmt->bindParam(':account_number', $account_number);
            $stmt->bindParam(':branch_name', $branch_name);
            $stmt->bindParam(':balance', $balance);
            $stmt->execute();
*/
/*
            if( $stmt->bind_param("iis", $patient_ID , $doctor_ID , $date) ){
                $patient_ID =  $_REQUEST['patient_id'];
                $doctor_ID = $_REQUEST['doctor_id'];
                $date = date('Y-m-d H:i:s');
                echo("<p>bind_param OK");
                echo("</p>");
            }else{
                echo("<p>Error: bind_param");
                echo("</p>");
            }
*/
            $stmt-> execute();
        }
        catch(PDOException $exception)
        {
            echo("<p>Error: ");
            echo($exception->getMessage());
            echo("</p>");
            exit();
        }

    ?>
    <p>Patient ID: <?php echo($_REQUEST['patient_id']); ?> </p>
    <p>Doctor ID: <?php echo($_REQUEST['doctor_id']); ?> </p>
    <p>date: <?php echo(date('Y-m-d H:i:s')); ?> </p>
    <p>END OF FILE :D</p>
  </body>

</html>