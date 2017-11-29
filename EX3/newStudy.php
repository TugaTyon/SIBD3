<?php
  require_once('sql_funcs.php');
  session_start();
/*
  if(isset($_REQUEST['submit'])){
    echo("Patient_ID: ".(int)$_REQUEST["patient_id"]);
    echo("<br>Doctor_ID: ".$_REQUEST["doctor_id"]);
    $_SESSION['try_name'] = $_POST['patient_name'];
  }
*/
?>

<html>
    <head>
      <title>Creating a new study</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
  <body onload="getMyHomePage()">
    <h2>Inserting your request into the Database</h2>
        <?php
            
            $connection = null;
            new_connection($connection);

            $date_now = date('Y-m-d H:i:s');
            $aux_null = null;

            $sql =  "INSERT INTO ist173065.Request VALUES (:number,:patient_id,:doctor_id,:date)";

            $result = sql_safe_query($connection, $sql, Array(":number" => $aux_null,
                                                                ":patient_id" => $_POST['patient_id'],
                                                                ":doctor_id" => $_POST['doctor_id'],
                                                                ":date" => $date_now));

            $sql = "SELECT number FROM ist173065.Request WHERE `date`= '" . $date_now . "'";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            /*$result = sql_safe_query($connection, $sql);*/
            if($stmt == TRUE)
            {
                $last_id = $stmt->fetchColumn();
                $_SESSION['req_num'] = $last_id;
                /*echo "New record created successfully. Last inserted ID is: " . $last_id;*/
                
            }else{
                echo("Error: " . $sql . "<br>" . $stmt->error);

            }
/*      
            $sql = "SELECT DISTINCT manufacturer FROM ist173065.Device";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
           
            if($stmt == TRUE)
            {
                echo ("<h3>Available Devices</h3>");
                echo("<table border=\"1\">");
                echo("<tr><td>manufacturer</td></tr>");
                
                foreach($stmt as $row)
                {
                    echo("</td><td>");
                    echo($row['manufacturer']);
                    echo("</td></tr>");
                    
                }
                echo("</table>");
            }else{
                echo("Error: " . $sql . "<br>" . $stmt->error);

            }
*/        
        ?>

        <form action="newSeries.php" method="post">
            <h3>Create new study</h3>
            <p>Insert short description for this study: <input type="text" name="study_description"/></p>
            
            <select onchange="get_models()" id="manuf" name="manufacturer"/>
                <option value=""  selected disabled>Device manufacturer</option>
                <?php
                    $result = sql_safe_query($connection, "SELECT DISTINCT manufacturer FROM ist173065.Device");

                    foreach($result as $row1){
                        echo("<option value=\"{$row1['manufacturer']}\"> {$row1['manufacturer']} </option>");
                    }
                ?>

            </select>
            <select name="model">
                <option selected="selected">Choose one</option>
                <?php
                    $result = sql_safe_query($connection, "SELECT * FROM ist173065.Device");
                    foreach($result as $value2) { 
                        echo("<option  class=\" hide_show {$value2['manufacturer']}\"  value=\"{$value2['model']}\"> {$value2['model']} </option>");
                    }
                ?>
            </select> 

            <input type="hidden" id="urlele" name="url" value="">
            <p><input type="submit" name="submit" value="Submit"/></p>
        </form>

        <?php
            $connection = null; 
            $_SESSION['doctor_id'] = $_POST['doctor_id'];
            $_SESSION['date_study'] = $date_now;
        
        ?>

        

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
    <script>
        function getMyHomePage() {
            var url = window.location.href ;
            var arr = url.split("/");
            var result = arr[0] + "//" + arr[2] + "/" + arr[3];
            document.getElementById("urlele").value = result;
        }
    </script>

</html>
