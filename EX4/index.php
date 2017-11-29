<html>
    <head>
      <title>Creating a new Element</title>
    </head>
  <body>
      <H2>Inputs: Where do you want to add a new element?</H2>
      
      <form action="newElement.php" method="post">
        <p>Insert the Series ID:<input type="text" name="series_id"/></p>
        <H4>Define the region please.</H4>
        <p>Insert x1:<input type="text" name="x1"/></p>
        <p>Insert x2:<input type="text" name="x2"/></p>
        <p>Insert y1:<input type="text" name="y1"/></p>
        <p>Insert y2:<input type="text" name="y2"/></p>
          
        <p><input type="submit" name="submit" value="Submit"/></p>
      </form>
  </body>
</html>