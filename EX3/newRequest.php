<html>
    <head>
      <title>Request an exam</title>
  </head>
  <body>
    <form action="newStudy.php" method="post">
        <h3>Doctor prescribing an exam</h3>
        <p>Please insert your doctor ID: <input type="number" name="doctor_id"/></p>
        <p>Please insert the patient ID : <input type="number" name="patient_id"/></p>
        <p>Exam type:
            <select name="exam_type">
            <option value="xray">X Ray</option>
            <option value="cholestrol">Cholesterol Reading</option>
            <option value="heartRate">Heart Rate</option>
            </select>
        </p>
      <p><input type="submit" name="submit" value="Submit"/></p>
    </form>
  </body>

</html>