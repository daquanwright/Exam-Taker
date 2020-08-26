<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Professor selects exam to view all submissions available</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div id="exam_column">

  <p id="Exam_Name">Exams Available:</p>

  <div id="exams_table_position">

    <table id="exams">

    </table>

  </div> <!-- exams_table_position -->

  <p id="exam_count"></p>

  <br><br>

  <a href="home.php" id="back">Back</a>

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
    form_data.append('Exam_Name', "All");

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
    });
  }
  search_exams();
///////////////////////////////////////////////////////////////////////
  // Populate tables with exam data
  function populate_tables()
  {
    var table = document.getElementById("exams");

    for (var i = 0; i < response.length; i++)
    {
      var row = table.insertRow(i);
      var name = row.insertCell(0);
      var test = row.insertCell(1);
      var form = document.createElement("form");
      form.setAttribute("action", "view-exam-submissions.php");
      form.setAttribute("method", "POST");
      var button = document.createElement("Button");
      button.setAttribute("name", "Exam_Name");
      button.setAttribute("value", exam_name);
      button.setAttribute("class", "submit")
      button.innerHTML = "View Submissions";
      form.appendChild(button);
      test.appendChild(form);

      name.innerHTML = response[i].Exam_Name;
    }
    var exam_column = document.getElementById("exam_column");
    var size = 80 * response.length + 90;
    exam_column.setAttribute("style", "height: "
    + size + "px;");
  }
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
