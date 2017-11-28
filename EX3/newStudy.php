<?php
  require_once('sql_funcs.php');
  session_start();

  if(isset($_REQUEST['submit'])){
    echo("Patient_ID: ".(int)$_REQUEST["patient_id"]);
    echo("<br>Doctor_ID: ".$_REQUEST["doctor_id"]);
    /*$_SESSION['try_name'] = $_POST['patient_name'];*/
  }

 

 
?>


<html>
    <head>
      <title>Creating a new study</title>
    </head>
  <body>
    <h3>Inserting into DB</h3>
        <?php
            
            $connection = null;
            new_connection($connection);

            $date_now = date('Y-m-d H:i:s');
            $aux_null = null;

            $sql =  "INSERT INTO ist173065.Request VALUES (:number,:patient_id,:doctor_id,:date)";
            echo("<p>Attempting to INSERT</p>");
            $result = sql_secure_query($connection, $sql, Array(":number" => $aux_null,
                                                                ":patient_id" => $_POST['patient_id'],
                                                                ":doctor_id" => $_POST['doctor_id'],
                                                                ":date" => $date_now));
            echo("<p>INSERTed</p>");
            $sql = "SELECT number FROM ist173065.Request WHERE `date`= '" . $date_now . "'";
            $stmt = $connection->prepare($sql);
            $stmt-> execute();
            
            if($stmt == TRUE)
            {
                echo("TRUE<br>");
                $last_id = $stmt->fetchColumn();
                
/*                $last_id = $stmt->lastInsertId();*/
                echo "New record created successfully. Last inserted ID is: " . $last_id;
                
            }else{
                echo("Error: " . $sql . "<br>" . $conn->error);
            }
            echo("<h4>POPOPO</h4>");
            $connection = null;

            
    /*        
            foreach ($_REQUEST as $exam_info => $value)
            {
                echo("<p>$exame_info = $value</p>");
            }

            try
            {

                $sql = "INSERT INTO ist173065.`Request` (`number`, `patient_id`, `doctor_id`, `date`) VALUES (null, '" . $_REQUEST['patient_id'] . "' , '" . $_REQUEST['doctor_id'] . "' , NOW() )";

                
                $patient_ID =  $_REQUEST['patient_id'];
                $doctor_ID = $_REQUEST['doctor_id'];
                $date = date('Y-m-d H:i:s');

                $stmt= $connection->prepare("INSERT INTO ist173065.`Request` (patient_id, doctor_id, `date`) VALUES (:patient_ID, :doctor_ID, :`date`)");

                
                if($stmt == false){
                    echo("<p>prepare returned FALSE");
                    echo("</p>");   
                }

                $stmt->bindParam(':patient_ID', $patient_ID);
                $stmt->bindParam(':doctor_ID', $doctor_ID);
                $stmt->bindParam(':date', $date);




                $account_number = $_REQUEST['account_number'];
                $branch_name = $_REQUEST['branch_name'];
                $balance = $_REQUEST['balance'];
                $stmt = $connection->prepare("INSERT INTO account
                VALUES (:account_number, :branch_name, :balance)");
                $stmt->bindParam(':account_number', $account_number);
                $stmt->bindParam(':branch_name', $branch_name);
                $stmt->bindParam(':balance', $balance);
                $stmt->execute();


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
            
            

        ?>
        <p>Patient ID: <?php echo($_POST['patient_id']); ?> </p>
        <p>Doctor ID: <?php echo($_POST['doctor_id']); ?> </p>
        <p>date: <?php echo($date_now); ?> </p>
        <p>END OF FILE :D</p>
  </body>

</html>