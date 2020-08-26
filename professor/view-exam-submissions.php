<!-- Daquan Wright - Front-end -->
<?php

  $exam = $_POST['Exam_Name'];

  $output = <<<EOD
              <p hidden id="Exam_Name">$exam</p>
              Exams submitted for <p>$exam:</p>
EOD;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Professor sees list of exam submissions for all students who have taken selected exam</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div class="exam_column">

    <p><?php echo $output; ?></p>

    <hr>

    <div id="exams_table_position">

      <table id="students">
        <tr>
          <th>Student</th>
          <th>Grade</th>
        </tr>
      </table>

    </div> <!-- exams_table_position -->

    <p id="exam_count"></p>

  <br><br><br>

  <a href="select-exam.php" id="back">Back</a>

  </div> <!-- Column -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare variables and arrays required for fetch operations
  var exam_name = document.getElementById("Exam_Name").innerHTML;

  var response;
  var size;
///////////////////////////////////////////////////////////////////////
// Search database for existing exams
  function search_exams()
  {
    var form_data = new FormData();
    form_data.append('operation', "Exam_Name_Search");
    form_data.append('Exam_Name', exam_name);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRens.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;

      size = response.length;
      populate_tables();
      document.getElementById("exam_count").innerHTML = "Exam Submissions Found: " + size;
    });
  }
  search_exams();
///////////////////////////////////////////////////////////////////////
  // Populate tables with student data
  function populate_tables()
  {
    var table = document.getElementById("students");

    for (var i = 0; i < response.length; i++)
    {
      var row = table.insertRow(i + 1);
      var name = row.insertCell(0);
      var grade = row.insertCell(1);
      var test = row.insertCell(2);

      var form = document.createElement("form");
      form.setAttribute("action", "review-exam.php");
      form.setAttribute("method", "POST");
      var button = document.createElement("button");
      button.setAttribute("name", "Exam");
      button.setAttribute("value", exam_name);
      button.setAttribute("class", "submit");
      button.innerHTML = "Review Exam";
      var input = document.createElement("input");
      input.hidden = true;
      input.setAttribute("name", "Student");
      input.setAttribute("value", response);

      form.appendChild(button);
      form.appendChild(input);
      test.appendChild(form);

      name.innerHTML = response[i].Student;
      grade.innerHTML = response[i].Grade;
    }
  }
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
