<?php
  session_start();
  $exam = $_POST['Exam_Name'];
  $user = $_POST['Student'];
?>

<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Student sees their exciting exam results!</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div class="exam_column">

    <p id="exam_name"></p>

    <hr>

    <p id="username"></p>

    <p id="question"></p>

    Answer:

    <br>

    <textarea readonly rows="15" cols="100" name="Answer" id="Answer"/></textarea>

    <p hidden id="question_ID"></p>

    <br>

    <p id="points">Points: </p>

    <div id="exams_table_position" class="results">

      <table id="answer_results">
          <tr>
            <th>Answer Results</th>
            <td>Answer Comments</td>
            <td>Points Obtained</td>
          </tr>
          <tr>
            <th>Function Results</th>
            <td><p id="function_comments"></p></td>
            <td><p id="function_points"></p></td>
          </tr>
          <tr>
            <th>Parameter Results</th>
            <td><p id="parameter_comments"></p></td>
            <td><p id="parameter_points"></p></td>
          </tr>
          <tr>
            <th>Constraint Results</th>
            <td><p id="constraint_comments"></p></td>
            <td><p id="constraint_points"></p></td>
          </tr>
          <tr>
            <th>Colon Results</th>
            <td><p id="colon_comments"></p></td>
            <td><p id="colon_points"></p></td>
          </tr>
          <tr>
            <th>Input Results</th>
            <td>Output Results</td>
            <td>Points Obtained</td>
          </tr>
          <tr>
            <td><p id="Input_1_Comments">Testcase 1 is correct. Input: '+',1,2</p></td>
            <td><p id="Output_1_Comments">Output: 3</p></td>
            <td><p id="Testcase_1_Points"></p>4</td>
          </tr>
          <tr>
            <td><p id="Input_2_Comments">Testcase 2 is good. Input: '-',5,3</p></td>
            <td><p id="Output_2_Comments">Output: 2</p></td>
            <td><p id="Testcase_2_Points"></p>0</td>
          </tr>
          <tr>
            <td><p id="Input_3_Comments">Testcase 3 is good. Input: '*',3,4</p></td>
            <td><p id="Output_3_Comments">Output: 12</p></td>
            <td><p id="Testcase_3_Points"></p>1</td>
          </tr>
          <tr>
            <td><p id="Input_4_Comments">Testcase 4 works out. Input: '/',10,2</p></td>
            <td><p id="Output_4_Comments">Output: 5</p></td>
            <td><p id="Testcase_4_Points">7</p></td>
          </tr>
          <tr>
            <td><p id="Input_5_Comments">Testcase 5 checks out. Input: '^',5,3</p></td>
            <td><p id="Output_5_Comments">Output: error</p></td>
            <td><p id="Testcase_5_Points">2</p></td>
          </tr>
          <tr>
            <th>Total Results</th>
            <td>Total Status</td>
            <td>Total Points</td>
          </tr>
          <tr>
            <td><p id="Total_Results">Overall good results!</p></td>
            <td><p id="Total_Status">You pass. . .no need to take again.</p></td>
            <td><p id="total_points">3</p></td>
          </tr>
      </table>

    </div> <!-- exams_table_position -->

    <br>

    Teacher Comments:

    <br>

    <textarea rows="10" cols="100" name="comment" id="comment"/></textarea>

    <br>

    <button class="submit" onclick="decrement_question()">Previous Question</button>

    <button class="submit" onclick="increment_questions()">Next Question</button>

    <p id="question_count"></p>

  <hr><p id="grade">Grade: 100</p><hr>

  <br><br>

  <a href="home.php" id="back">Student Homepage</a>

  <br><br><br><br>

  <a href="../login.html" id="back">Logout</a>

  </div> <!-- Column -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare variables and arrays required for fetch operations
  var exam_name = document.getElementById("exam_name").innerHTML;

  var question_content = [];
  var comment_content = [];
  var point_content = [];
  var total_points = [];
  var function_points = [];
  var constraint_points = [];
  var parameter_points = [];
  var colon_points = [];
  var test_points = [];
  var question_ID = [];
  var send_data = new FormData();

  // Fetch fills these variables
  var response;

  var size;
  var exam_size = 0;

  var increment_question = 0;
  var form_data = new FormData();
  var page = 1;
  var exam_page = 1;
///////////////////////////////////////////////////////////////////////
  // Retrieve exam questions for professor to grade
  function retrieve_questions() {
    var Exam_Name = document.getElementById("exam_name").innerHTML;
    var username = document.getElementById("username").innerHTML;

    var form_data = new FormData();
    form_data.append('operation', "Retrieve_Answers");
    form_data.append('Exam_Name', "TricksAreForKids");
    form_data.append('Username', "student");
    form_data.append('Question_IDs', question_ID);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRvgr.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;
      size = response.length;

      populate_questions();
      getCount();
      document.getElementById("question_count").innerHTML = "Question " + page + " of " + size;
    });
  }
///////////////////////////////////////////////////////////////////////
  retrieve_questions();
  // Fill exam with list of questions
  function getCount()
  {
    for (i = 0; i < size; i++)
    {
      var data = response[i];
      // don't need anything commented out here, probably best to save a copy in case though
      //var bind_question_IDs = [];
      //bind_question_IDs = question_ID = data.ID;
      question_content = data.Question;
    //  function_points[i]=data.Function_Points;
      //parameter_points[i]=data.Parameter_Points;
      //ids[i]=data.QuestionID;
    //  constraint_points[i]=data.Constraint_Points;
    //  colon_points[i]=data.Colon_Points;
      //IDs = data.ID;
      points = data.Points;
      //question_ID[i]= data.ID;
       // console.log(question_ID[i]);
       question_ID[i]= data.QuestionID;
    }
      populate_questions();
  }


///////////////////////////////////////////////////////////////////////
  function populate_questions()
  {
    if (increment_question < size)
    {
      data = response[increment_question];
      exam = data.ExamName;
      username = data.UserName;
      quest = question_content = data.question;
      answe = data.Answer;
      ids = data.QuestionID;
      functionComments = data.Function_Comments;
      functionPoints = data.Function_Points;
      parameterComments = data.Parameter_Comments;
      parameterPoints = data.Parameter_Points;
      constraintComments = data.Constraint_Comments;
      constraintPoints = data.Constraint_Points;
      colonComments = data.Colon_Comments;
      colonPoints = data.Colon_Points;
      sumPoints = data.Sum_Points;
      totalPoints = data.Points;

      document.getElementById("question").innerHTML = "Question: " + quest;
      document.getElementById("question_count").innerHTML = "Question " + page + " of " + size;
      document.getElementById("Answer").innerHTML = answe;
      document.getElementById("question_ID").innerHTML = ids;
      document.getElementById("exam_name").innerHTML = "Exam: " + exam;
      document.getElementById("username").innerHTML = "Student: " + username;
      document.getElementById("points").innerHTML = "Points: " + totalPoints;

      document.getElementById("function_comments").innerHTML = functionComments;
      document.getElementById("parameter_comments").innerHTML = parameterComments;
      document.getElementById("constraint_comments").innerHTML = constraintComments;
      document.getElementById("colon_comments").innerHTML = colonComments;
      //document.getElementById("Total_Results").innerHTML = totalResults;
      //document.getElementById("Total_Status").innerHTML = Total_Points;

      document.getElementById("function_points").innerHTML = functionPoints;
      document.getElementById("parameter_points").innerHTML = parameterPoints;
      document.getElementById("constraint_points").innerHTML = constraintPoints;
      document.getElementById("colon_points").innerHTML = colonPoints;
      document.getElementById("total_points").innerHTML = totalPoints;

      //populate_tables(increment_question);
    }
  }
///////////////////////////////////////////////////////////////////////
  // Populate question with retrieved data from the server
  /*function populate_questions()
  {
    if (increment_question < size)
    {
      document.getElementById("question").innerHTML = "Question: " + response.question_content[increment_question];
      document.getElementById("question_count").innerHTML = "Question" + page + " of " + size;
      document.getElementById("Answer").innerHTML = response.answer_content[increment_question];
      document.getElementById("comment").innerHTML = response.teacher_comments[increment_question];
      populate_tables(increment_question);
    }
  }*/
///////////////////////////////////////////////////////////////////////
  // Cycle up question list
  function increment_questions()
  {
   if (increment_question < size - 1)
   {
     // it has to go in this specific order for the first/last answer/question to match
    //var x=  document.getElementById("question_ID").value;
    //console.log(x);
       document.getElementById("comment").value;
       document.getElementById("constraint_points").value;
       document.getElementById("constraint_comments").innerHTML;
       document.getElementById("function_points").value;
       document.getElementById("function_comments").innerHTML;
       document.getElementById("colon_points").value;
       document.getElementById("colon_comments").innerHTML;
       document.getElementById("parameter_points").value;
       document.getElementById("parameter_comments").innerHTML;
       document.getElementById("total_points").value;
       document.getElementById("question_ID").innerHTML = ids;
     //release_exam();
     increment_question++;

    //document.getElementById("Answer").value= answer_content[increment_question];
    //document.getElementById("IDs").value= question_ID[increment_question];
    //console.log(document.getElementById("IDs").value)//= question_ID[increment_question]);

     page++;
     populate_questions();
   }

  }
///////////////////////////////////////////////////////////////////////
  // Increment question
  /*function increment_questions()
  {
    if (increment_question < size - 1)
    {
      save_content(increment_question);
      increment_question++;
      document.getElementById("comment").value = comment_content[increment_question];
      document.getElementById("points").value = point_content[increment_question];
      page++;
      empty_tables();
      populate_questions();
    }
  }*/

///////////////////////////////////////////////////////////////////////
  // Decrement question
  function decrement_question()
  {
    if (increment_question > 0)
    {
      //save_content(increment_question);
      increment_question--;
      document.getElementById("comment").value = comment_content[increment_question];
      document.getElementById("points").value = point_content[increment_question];
      page--;
      //empty_tables();
      populate_questions();
    }
  }
///////////////////////////////////////////////////////////////////////
  // Save changes to graded and reviewed exam
  function save_content(i)
  {
    comment_content[increment_question] = document.getElementById("comment").value;
    function_points[increment_question] = document.getElementById("function_points").value;
    parameter_points[increment_question] = document.getElementById("parameter_points").value;
    constraint_points[increment_question] = document.getElementById("constraint_points").value;
    colon_points[increment_question] = document.getElementById("colon_points").value;

    for (var j = 0; j < total_points.length; j++)
    {
      test_points[increment_question][j] = document.getElementById("point_input" + (j + 4)).value;
    }
  }
///////////////////////////////////////////////////////////////////////
  // Submit reviewed and graded exam with comments
  function submit_exam()
  {
    save_content(increment_question);
    var username = document.getElementById("username").innerHTML;
    var Exam_Name = document.getElementById("exam_name").innerHTML;

    var send_comments = [];
    var comment_content = [];

    for (var i = 0; i < comment_content.length; i++)
    {
      send_comments.push(comment_content[i].replace(/,/g, "~"));
    }

    for (var i = 0; i < size; i++)
    {
      total_points[i] = 0;
      total_points[i] += parseInt(function_points[i]);
      total_points[i] += parseInt(constraint_points[i]);
      total_points[i] += parseInt(colon_points[i]);
      total_points[i] += parseInt(parameter_points[i]);

      for (var j = 0; j < total_points[i].length; j++)
      {
        total_points[i] += parseInt(total_points[i][j]);
      }
    }

    var test_string = "";

    for (var i = 0; i < size; i++)
    {
      for (j = 0; j < total_points[i].length; j++)
      {
        test_string += total_points[i][j];

        if (j != total_points[i].length-1)
        {
          test_string += "~";
        }
      }
      if (i != size - 1)
      {
        test_string += ",";
      }
    }

    send_data.append('operation', 'Professor_Submit_Exam');
    send_data.append('Exam_Name', Exam_Name);
    send_data.append('Username', username);
    //send_data.append('Test_Points', Test_Points);
    send_data.append('total_points', total_points);
    send_data.append('function_points', function_points);
    send_data.append('parameter_points', parameter_points);
    send_data.append('constraint_points', constraint_points);
    send_data.append('colon_points', colon_points);
    send_data.append('comments', send_comments);

    for (var pair of send_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRvgr.php';

    const options = {
      method: 'POST',
      body: send_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      document.getElementById("submit_exam_status").innerHTML = "Exam saved and submitted for student to review their results!";
    });
  }
///////////////////////////////////////////////////////////////////////
  /*function populate_tables(j)
  {
    //empty_tables();
    var count = 0;
    var table = document.getElementById("results");

    for (var i = 0; i < j; i++)
    {
      var row = table.insertRow(1);

      var data = response[i];
      var Function_Points = row.insertCell(0);
      var Parameter_Points = row.insertCell(1);
      var Constraint_Points = row.insertCell(2);
      var Colon_Points = row.insertCell(3);
      var Input = row.insertCell(4);
      var Output = row.insertCell(5);
      var Total_Points = row.insertCell(5);

      Function_Points.innerHTML = data["Function_Points"];
      Parameter_Points.innerHTML = data["Parameter_Points"];
      Constraint_Points.innerHTML = data["Constraint_Points"];
      Colon_Points.innerHTML = data["Colon_Points"];
      Input.innerHTML = data["Input"];
      Output.innerHTML = data["Output"];
      Total_Points.innerHTML = data["Total_Points"];

      document.getElementById("Function_Points").value = data['Function_Points'];

  }
}*/
///////////////////////////////////////////////////////////////////////
  // Populate tables with question data
  /*function populate_tables(j)
  {
    empty_tables();
    var count = 0;
    var table = document.getElementById("results");

    //comments = response["middle_comments"][j].split('~');

    // Switch "0" with "j"
    if (Comments[0] != "")
    {
      var row = table.insertRow(-1);
      var cell_1 = row.insertCell(0);
      cell_1.innerHTML = "<b>" + comments[0] + "</b>";
      cell_1.colSpan = "3";
    }

    var row = table.insertRow(-1);
    var cell_1 = row.insertCell(0);
    cell_1.colSpan = "2";
    var cell_3 = row.insertCell(1);
    cell_1.innerHTML = "<b>Answer Comments</b>";
    cell_3.innerHTML = "<b>Points Obtained</b>";

    for (var i = 1; i < comments.length - 1; i++)
    {
      var row = table.insertRow(-1);
      var cell_1 = row.insertCell(0);
      cell_1.innerHTML = comments[i];
      cell_1.colSpan = "2";
      var cell_2 = row.insertCell(1);
      var points = document.createElement("input");
      var name = "point_input" + count;
      points.setAttribute("id", name);
      points.size = "10";

      switch(i) {
        case 1:
          points.setAttribute("value", function_points[j]);
          break;
        case 2:
          points.setAttribute("value", parameter_points[j]);
          break;
        case 3:
          points.setAttribute("value", constraint_points[j]);
          break;
        case 4:
          points.setAttribute("value", colon_points[j]);
          break;
        default:
      }
      cell_2.appendChild(points);
      count++;
    }

    var row = table.insertRow(-1);
    var cell_1 = row.insertCell(0);
    var cell_2 = row.insertCell(1);
    var cell_3 = row.insertCell(2);
    cell_1.innerHTML = "<b>Input</b>";
    cell_2.innerHTML = "<b>Output</b>";
    cell_3.innerHTML = "<b>Points Obtained</b>";
    test_cases = comments[comments.length - 1].split('@');
    test_cases_points = response.test_points[j].split('~');

    if (comments[0] == "")
    {
      for (var i = 0; i < test_cases.length - 1; i += 2)
      {
        if (test_cases[i] != "")
        {
          var row = table.insertRow(-1);
          var cell_1 = row.insertCell(0);
          var cell_2 = row.insertCell(1);
          var cell_3 = row.insertCell(2);
          cell_1.innerHTML = test_cases[i];

          if (test_cases[i + 1].includes("Runtime Error"))
          {
            var act_index = test_cases[i + 1].indexOf("Actual");
            cell_2.innerHTML = test_cases[i + 1].substr(0, act_index);
          }
          else
          {
            cell_2.innerHTML = test_cases[i + 1];
          }
          var points = document.createElement("input");
          points.setAttribute("value", test_points[j][i/2]);
          var name = "point_input" + count;
          points.setAttribute("id", name);
          points.size = "10";
          cell_3.appendChild(points);
          count++;
        }
      }
    }
    else
    {
      for (var i = 0; i < test_cases.length; i++)
      {
        if (test_cases[i] != "")
        {
          var row = table.insertRow(-1);
          var cell_1 = row.insertCell(0);
          cell_1.colSpan = "2";
          cell_1.innerHTML = test_cases[i];
          var cell_3 = row.insertCell(1);
          var points = document.createElement("input");
          points.setAttribute("value", test_points[j][i]);
          var name = "point_input" + count;
          points.setAttribute("id", name);
          points.size = "10";
          cell_3.appendChild(points);
          count++;
        }
      }
    }

    var sum = 0;

    for (var i = 0; i < count; i++)
    {
      sum += parse_int(document.getElementById("point_input" + i).value);
    }
    document.getElementById("points").innerHTML = "Points: " + sum + "/" + response.total_points[increment_question];
  }*/
///////////////////////////////////////////////////////////////////////
  // Empty tables with exam questions data
  /*function empty_tables()
  {
    var table = document.getElementById("results");
    var rows = table.children[0];
    var x = rows.children.length;

    for (var i = 0; i < x; i++)
    {
      rows.removeChild(rows.lastElementChild);
    }
  }*/
///////////////////////////////////////////////////////////////////////
// Release exam for student to see their results
function release_exam()
{
  comment_content[increment_question] = document.getElementById("comment").value;
  //console.log(comment_content);
  function_points[increment_question] = document.getElementById("function_points").value;
  parameter_points[increment_question] = document.getElementById("parameter_points").value;
  constraint_points[increment_question] = document.getElementById("constraint_points").value;
  colon_points[increment_question] = document.getElementById("colon_points").value;
  question_ID[increment_question] = document.getElementById("question_ID").innerHTML;
  console.log(question_ID);
  var form_data = new FormData();
  form_data.append('operation', "Release_Exam");
  form_data.append('Exam_Name', exam_name);
  form_data.append('comment_content', comment_content);
  form_data.append('function_points', function_points);
  form_data.append('function_comments', function_comments);
  form_data.append('parameter_points', parameter_points);
  form_data.append('parameter_comments', parameter_comments);
  form_data.append('constraint_points', constraint_points);
  form_data.append('constraint_comments', constraint_comments);
  form_data.append('colon_points', colon_points);
  form_data.append('colon_comments', colon_comments);
  form_data.append('question_id', question_ID);
  form_data.append('counter', increment_question);

  for (var key of form_data.entries()) {

   console.log(key[0]+ ', '+ key[1]);
  }

  const url = 'https://web.njit.edu/~kjk42/CS490Test/mRch.php';

  const options = {
    method: 'POST',
    body: form_data
  };

  fetch(url, options).then(promised_results =>
  promised_results.json()).then(data => {
    console.log(data)
    document.getElementById("release_exam_status").innerHTML = "Exam was released for student to see their results!";
  });
}
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
