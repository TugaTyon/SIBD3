
<html>
    <head>
      <title>Creating a new series</title>
    </head>
    <body>
        <H1>Success!</H1>
        <p>Successfully inserted the information in the database.</p>
        <p>Go back to the beggining to insert some more?</p>        
        <button onclick="redirect()">Go back</button>
    </body>

    <script>
        function redirect() {
            var url = window.location.href ;
            var arr = url.split("/");
            //var result = arr[0] + "//" + arr[2] + "/" + arr[3] + "/newRequest.php";
            result = "http://web.ist.utl.pt/ist173065/SIBD3/EX3/newRequest.php";
            window.location = result;
        }
    </script>
</html>
