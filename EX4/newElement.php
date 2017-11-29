<?php
  require_once('sql_funcs.php');
  session_start();

?>

<html>
    <head>
      <title>Insert new Element in db</title>
    </head>
  <body>
    <?php
        $connection = null;
        new_connection($connection);

        $sql = "SELECT elem_index FROM Element";
        $result2 = sql_safe_query($connection, $sql);

        
        $sql = "SELECT region_overlaps_element(:series_id,:elem_index,:x1,:y1,:x2,:y2)";
        $cnt = 0;
        foreach($result2 as $elem_index_iterator){

            
            $result = sql_safe_query($connection, $sql, Array(":series_id" => $_POST['series_id'],
                                                        ":elem_index" => $elem_index_iterator[$cnt],
                                                        ":x1" => $_POST['x1'],
                                                        ":y1" => $_POST['y1'],
                                                        ":x2" => $_POST['x2'],
                                                        ":y2" => $_POST['y2']));
            if ($result == FALSE)
            {
                $info =  $connection->errorInfo();
                echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
                exit();
            }
        
            $function_result = $result->fetch();
            
            if ($function_result[0] == 0) {
                echo "<p>NO OVERLAP</p>";
                $overlap = false;
            }else{
                echo "<p>OVERLAP</p>";
                $overlap = true;
                break;
            }
            $cnt++;
        }

        $sql = "SELECT MAX(elem_index) AS elem_index FROM Element";
        $result = sql_safe_query($connection, $sql);
        
        if($result == TRUE)
        {
            $last_index = $result->fetchColumn();
            $new_elem_index = $last_index+1;

        }else{
            echo("Error: " . $sql . "<br>" . $stmt->error);

        }

        $sql ="INSERT INTO Element VALUES (:series_id,:elem_index)"; 
        $result = sql_safe_query($connection, $sql, Array(":series_id" => $_POST['series_id'],
                                                            ":elem_index" => $new_elem_index));

        $sql ="INSERT INTO Region VALUES (:series_id,:elem_index,:x1,:y1,:x2,:y2)"; 
        $result = sql_safe_query($connection, $sql, Array(":series_id" => $_POST['series_id'],
                                                            ":elem_index" => $new_elem_index,
                                                            ":x1" => $_POST['x1'],
                                                            ":y1" => $_POST['y1'],
                                                            ":x2" => $_POST['x2'],
                                                            ":y2" => $_POST['y2']));
        if($overlap == FALSE){
            header("Location: http://web.ist.utl.pt/ist173065/SIBD3/EX4/no_overlap.php");
        }else{
            header("Location: http://web.ist.utl.pt/ist173065/SIBD3/EX4/overlap.php");
        }
  
    ?>

  </body>
</html>