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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
            $stmt->execute();
            
            if($stmt == TRUE)
            {
                echo("TRUE<br>");
                $last_id = $stmt->fetchColumn();
                echo "New record created successfully. Last inserted ID is: " . $last_id;
                
            }else{
                echo("Error: " . $sql . "<br>" . $stmt->error);

            }
            
            echo("<h4>going for the devices now</h4>");

            $sql = "SELECT DISTINCT manufacturer FROM ist173065.Device";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            echo("<h4>going for the devices now</h4>");
            if($stmt == TRUE)
            {
                echo ("<h3>Available Devices</h3>");
                echo("<table border=\"1\">");
                echo("<tr><td>manufacturer</td></tr>");
                
                /*$cnt = 0;*/
                foreach($stmt as $row)
                {
                    echo("</td><td>");
                    echo($row['manufacturer']);
                    echo("</td></tr>");
                    /*$manuf_array[$cnt] = $row['manufacturer'];
                    $model_array[$cnt] = $row['model'];
                    $device_array[$cnt] = ( $row['manufacturer'] . " - " . $row['model']);
                    $cnt = $cnt+1;*/
                }
                echo("</table>");
            }else{
                echo("Error: " . $sql . "<br>" . $stmt->error);

            }
            
        ?>

        <form action="newSeries.php" method="post">
            <h3>Create new study</h3>
            <p>Insert short description for this study: <input type="text" name="study_description"/></p>
            
            <select onchange="get_models()" id="manuf" name="manufacturer"/>
                <option value=""  selected disabled>Device manufacturer</option>
                <?php
                    $result = sql_secure_query($connection, "SELECT DISTINCT manufacturer FROM ist173065.Device");

                    foreach($result as $row1){
                        echo("<option value=\"{$row1['manufacturer']}\"> {$row1['manufacturer']} </option>");
                    }
                ?>

            </select>

            <?php
              /*  $sql = "SELECT DISTINCT model FROM ist173065.Device";
                $stmt = $connection->prepare($sql);
                $stmt->execute();*/
            ?>

            <select name="model">
                <option selected="selected">Choose one</option>
                <?php
                    $result = sql_secure_query($connection, "SELECT * FROM ist173065.Device");
                    foreach($result as $value2) { 
                        echo("<option  class=\" hide_show {$value2['manufacturer']}\"  value=\"{$value2['model']}\"> {$value2['model']} </option>");
                    }
                ?>
            </select> 

            

            <p><input type="submit" name="submit" value="Submit"/></p>
        </form>

        <?php $connection = null; ?>

        <p>Patient ID: <?php echo($_POST['patient_id']); ?> </p>
        <p>Doctor ID: <?php echo($_POST['doctor_id']); ?> </p>
        <p>date: <?php echo($date_now); ?> </p>
        <p>END OF FILE :D</p>
    </body>


    <script>
        function get_models(){
        var manuf = $("#manuf option:selected").val();
        /*Show only models that this manufacturer has*/
        $('.hide_show').prop('disabled', true);
        /*Show all models that this manufacturer has*/
        $('.' + manuf).prop('disabled', false);
        $('[name=model]').val( '' );
        
        }
    </script>

</html>
