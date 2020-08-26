<!-- Daquan Wright - Front-end -->
<?php
  session_start();

  if (!empty($_POST['select_exam_1']))
  {
    $exam = $_POST['select_exam_1'];
  }
  elseif (!empty($_POST['select_exam_2']))
  {
    $exam = $_POST['select_exam_2'];
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Student sees all exams available to review under their account</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div id="exam_column">

    <p>Available Exams:</p>

    <p id="exam_name"></p>

    <p hidden id="select_exam"><?php echo $exam; ?></p>
    <p hidden id="username"><?php echo $_SESSION["username"]; ?></p>

    <div id="exams_table_position">

      <table id="exams">

      </table>

    </div> <!-- exams_table_position -->

    <p id="exam_count"></p>

  <br><br><br>

  <a href="home.php" id="back">Back</a>

  </div> <!-- Column -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare variables and arrays required for fetch operations
  var response = [];
  var size;

  if (document.getElementById("select_exam").innerHTML)
  {
    search_exams_by_user();
  }
  else
  {
    search_exams_by_user();
  }
///////////////////////////////////////////////////////////////////////
// Search database for all exams
  function search_exams()
  {
    var form_data = new FormData();
    form_data.append('operation', "Exam_Search");
    form_data.append('Exam_Name', "All");

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~dw269/beta/front-end.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;
      populate_tables();
    });
  }
///////////////////////////////////////////////////////////////////////
// Search database for all exams by user
  function search_exams_by_user()
  {
    //var exam_name = document.getElementById("exam_name").value =
    //document.getElementById("exam_name").innerHTML;
    var username = document.getElementById("username").innerHTML;

    var form_data = new FormData();
    form_data.append('operation', "Exam_User_Search");
    form_data.append('Exam_Name', exam_name);
    form_data.append('Username', username);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRsebu.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;
      //size = response.Exam_Name.length;
      populate_tables(1);
    });
  }
///////////////////////////////////////////////////////////////////////
  // Populate tables with student data
  function populate_tables(j)
  {
    var table = document.getElementById("exams");

    if (j)
    {
      var count = 0;
      /*for (var i = 0; i < response.Exam_Name.length; i++)
      {
        if (response.released_exam[i] == "1")
        {
          var row = table.insertRow(count);
          var Name = row.insertCell(0);
          var test = row.insertCell(1);
          var form = document.createElement("form");
          form.setAttribute("action", "review-exam-results.php");
          form.setAttribute("method", "POST");
          var button = document.createElement("Button");
          button.setAttribute("name", "Exam_Name");
          button.setAttribute("value", response.Exam_Name[i]);
          button.setAttribute("class", "submit")
          button.innerHTML = "Review Exam Results";

          form.appendChild(button);
          test.appendChild(form);

          name.innerHTML = response.Exam_Name[i];
          count++;
        }
      }
      var exam_column = document.getElementById("exam_column");
      var size = 80 * response.length + 90;
      exam_column.setAttribute("style", "height: "
      + size + "px;");
    }
    else
    {*/
      for (var i = 0; i < response.length; i++)
      {
        var row = table.insertRow(i);
        var name = row.insertCell(0);
        var test = row.insertCell(1);
        var form = document.createElement("form");
        form.setAttribute("action", "take-exam.php");
        form.setAttribute("method", "POST");
        var button = document.createElement("button");
        button.setAttribute("name", "Exam_Name");
        button.setAttribute("value", response[i].Exam_Name);
        button.setAttribute("class", "submit")
        button.innerHTML = "Take Exam";

        form.appendChild(button);
        test.appendChild(form);
        name.innerHTML = response[i].Exam_Name;
      }
      var exam_column = document.getElementById("exam_column");
      var size = 80 * response.length + 90;
      exam_column.setAttribute("style", "height: " + size + "px;");
    }
  }
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
