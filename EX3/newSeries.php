<?php
  require_once('sql_funcs.php');
  session_start();

?>

<html>
    <head>
      <title>Creating a new series</title>
    </head>
    <body>

        <?php
            $connection = null;
            new_connection($connection);

            $myURL = $_POST['url'];            

            $sql =  "SELECT serialnum FROM Device WHERE manufacturer = '" . $_POST['manufacturer'] . "' AND model = '" . $_POST['model'] . "'";
            $result = sql_safe_query($connection, $sql);
            $snum = $result->fetchColumn();
            

            $connection->beginTransaction();

            $sql =  "INSERT INTO Study VALUES (:req_num,:description,:date,:doctor_id,:manuf,:serial_num)";
            $result = sql_safe_query($connection, $sql, Array(":req_num" => $_SESSION['req_num'],
                                                                ":description" => $_POST['study_description'],
                                                                ":date" => $_POST['date_study'],
                                                                ":doctor_id" => $_SESSION['doctor_id'],
                                                                ":manuf" => $_POST['manufacturer'],
                                                                ":serial_num" => $snum));

            if($result == FALSE){
/*ERROR INSERTING in Study*/
                $info =  $connection->errorInfo();
                echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
                $connection->rollback();
                header("Location: http://web.ist.utl.pt/ist173065/SIBD3/EX3/insert_fail.php");
            }else{
                //echo("<br>Inserted in Study<br>");
            
                
                $sql =  "SELECT MAX(series_id) AS series_id FROM Series";
                $result = sql_safe_query($connection, $sql);
                $last_series_id = $result->fetchColumn();
                $new_series_id = $last_series_id+1;

                $series_url = $myURL . "/series/" . $new_series_id;

                $series_name = "TEST";
                

                $sql =  "INSERT INTO Series VALUES (:series_id,:name,:base_url,:req_number,:description)";
                $result = sql_safe_query($connection, $sql, Array(":series_id" => $new_series_id,
                                                                    ":name" => $series_name,
                                                                    ":base_url" => $series_url,
                                                                    ":req_number" => $_SESSION['req_num'],
                                                                    ":description" => $_POST['study_description']));

                if($result == FALSE){
    /*ERROR INSERTING in Series*/
                    $info =  $connection->errorInfo();
                    echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
                    $connection->rollback();
                    header("Location: http://web.ist.utl.pt/ist173065/SIBD3/EX3/insert_fail.php");
                }else{
                    //echo("<br>Inserted in Series<br>");
                    $connection->commit();
                    header("Location: http://web.ist.utl.pt/ist173065/SIBD3/EX3/insert_success.php");
                }
                
            }
        ?>
    
    </body>
</html>