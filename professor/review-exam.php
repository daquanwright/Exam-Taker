<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Professor selects exam to review and score with comments</title>
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
            <th>Def Results</th>
            <td><p id="def_comments"></p></td>
            <td><input id="def_points" name="def_points" size="5"></td>
          </tr>
          <tr>
            <th>Function Results</th>
            <td><p id="function_comments"></p></td>
            <td><input id="function_points" name="function_points" size="5"></td>
          </tr>
          <tr>
            <th>Parameter Results</th>
            <td><p id="parameter_comments"></p></td>
            <td><input id="parameter_points" name="parameter_points" size="5"></td>
          </tr>
          <tr>
            <th>Constraint Results</th>
            <td><p id="constraint_comments"></p></td>
            <td><input id="constraint_points" name="constraint_points" size="5"></td>
          </tr>
          <tr>
            <th>Colon Results</th>
            <td><p id="colon_comments"></p></td>
            <td><input id="colon_points" name="colon_points" size="5"></td>
          </tr>
          <tr>
            <th>Input Results</th>
            <td>Output Results</td>
            <td>Points Obtained</td>
          </tr>
          <tr>
            <td><p id="Input_1_Comments"></p></td>
            <td><p id="Output_1_Comments"></p></td>
            <td><input id="Testcase_1_Points" name="Testcase_1_Points" size="5"></td>
          </tr>
          <tr>
            <td><p id="Input_2_Comments"></p></td>
            <td><p id="Output_2_Comments"></p></td>
            <td><input id="Testcase_2_Points" name="Testcase_2_Points" size="5"></td>
          </tr>
          <tr>
            <td><p id="Input_3_Comments"></p></td>
            <td><p id="Output_3_Comments"></p></td>
            <td><input id="Testcase_3_Points" name="Testcase_3_Points" size="5"></td>
          </tr>
          <tr>
            <td><p id="Input_4_Comments"></p></td>
            <td><p id="Output_4_Comments"></p></td>
            <td><input id="Testcase_4_Points" name="Testcase_4_Points" size="5"></td>
          </tr>
          <tr>
            <td><p id="Input_5_Comments"></p></td>
            <td><p id="Output_5_Comments"></p></td>
            <td><input id="Testcase_5_Points" name="Testcase_5_Points" size="5"></td>
          </tr>
          <tr>
            <th>Total Results</th>
            <td>Total Status</td>
            <td>Total Points</td>
          </tr>
          <tr>
            <td><p id="Total_Results">Overall good results!</p></td>
            <td><p id="Total_Status">You pass. . .no need to take again.</p></td>
            <td><input id="total_points" name="total_points" size="5"></td>
          </tr>
      </table>

    </div> <!-- exams_table_position -->

    <br>

    Teacher Comments:

    <br>

    <textarea rows="10" cols="100" name="comments" id="comments"/></textarea>

    <br>

    <button class="submit" onclick="decrement_question()">Previous Question</button>

    <button class="submit" onclick="increment_questions()">Next Question</button>

    <p id="question_count"></p>

    <hr>Grade: <input id="grade" name="grade" size="5"><hr>

    <button class="submit" onclick="submit_exam()">Submit Exam</button>

    <button class="submit" onclick="release_exam()">Release Exam</button>

    <p id="submit_exam_status"></p>

    <p id="release_exam_status"></p>

  <br><br>

  <a href="home.php" id="back">Professor Homepage</a>

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
  var def_points = [];
  var function_comments = [];
  var function_points = [];
  var constraint_comments = [];
  var constraint_points = [];
  var parameter_comments = [];
  var parameter_points = [];
  var colon_comments = [];
  var colon_points = [];
  var testcase_points;
  var question_ID = [];
  var send_data = new FormData();
  var answer;
  var function_points;
  var tcp1;
  var tcp2;
  var tcp3;
  var tcp4;
  var tcp5;
  var tcp6;
  var occ1;
  var occ2;
  var occ3;
  var occ4;
  var occ5;
  var occ6;
  var tcc1;
  var tcc2;
  var tcc3;
  var tcc4;
  var tcc5;
  var tcc6;

  var testCP;

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
    form_data.append('Exam_Name', Exam_Name);
    form_data.append('Username', username);
    form_data.append('Question_IDs', question_ID);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/profViewExam2.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;
      size = response.length;

      for (var i = 0; i < size; i++)
      {
        comment_content[i] = "";
        //testcase_points.push(response.testcase_points[i].split('|'));
      }

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
      function_points[i]=data.function_Points;
      //parameter_points[i]=data.Parameter_Points;
      //ids[i]=data.QuestionID;
    //  constraint_points[i]=data.Constraint_Points;
    //  colon_points[i]=data.Colon_Points;
      //IDs = data.ID;
      points = data.Points;

      //question_ID[i]= data.ID;
       // console.log(question_ID[i]);
       question_ID[i]= data.QuestionID;
      // console.log(question_ID);
      // console.log(function_points);
    }
      populate_questions();
  }


///////////////////////////////////////////////////////////////////////
  function populate_questions()
  {

    if (increment_question < size)
    {

      data = response[increment_question];
      //console.log(data);
      exam = data.ExamName;
      username = data.UserName;
      quest = question_content = data.question;
      answe = data.Answer;
      ids = data.QuestionID;
      defComments = data.Def_Comments;
      defPoints = data.Def_Points;
      functionComments = comment_content = data.Function_Comments;
      functionPoints = data.Function_Points;
      parameterComments = data.Parameter_Comments;
      parameterPoints = data.Parameter_Points;
      constraintComments = data.Constraint_Comments;
      constraintPoints = data.Constraint_Points;
      colonComments = data.Colon_Comments;
      colonPoints = data.Colon_Points;
      sumPoints = data.Sum_Points;
      totalPoints = data.Points;
      testCP = data.TestCasePoints;

      tcp1 = data.TCP1;
      tcp2 = data.TCP2;
      tcp3 = data.TCP3;
      tcp4 = data.TCP4;
      tcp5 = data.TCP5;
      tcp6 = data.TCP6;

      occ1 = data.OCC1;
      occ2= data.OCC2;
      occ3= data.OCC3;
      occ4= data.OCC4;
      occ5= data.OCC5;
      occ6= data.OCC6;

      tcc1= data.TCC1;
      tcc2= data.TCC2;
      tcc3= data.TCC3;
      tcc4=data.TCC4;
      tcc5=data.TCC5;
      tcc6=data.TCC6;

      document.getElementById("Input_1_Comments").innerHTML=tcc1;
      document.getElementById("Input_2_Comments").innerHTML=tcc2;
      document.getElementById("Input_3_Comments").innerHTML=tcc3;
      document.getElementById("Input_4_Comments").innerHTML=tcc4;
      document.getElementById("Input_5_Comments").innerHTML=tcc5;

      document.getElementById("Output_1_Comments").innerHTML=occ1;
      document.getElementById("Output_2_Comments").innerHTML=occ2;
      document.getElementById("Output_3_Comments").innerHTML=occ3;
      document.getElementById("Output_4_Comments").innerHTML=occ4;
      document.getElementById("Output_5_Comments").innerHTML=occ5;

      document.getElementById("Testcase_1_Points").value=tcp1;
      document.getElementById("Testcase_2_Points").value=tcp2;
      document.getElementById("Testcase_3_Points").value=tcp3;
      document.getElementById("Testcase_4_Points").value=tcp4;
      document.getElementById("Testcase_5_Points").value=tcp5;
      //document.getElementById("Testcase_6_Points").value=tcp6;

      document.getElementById("question").innerHTML = "Question: " + quest;
      document.getElementById("question_count").innerHTML = "Question " + page + " of " + size;
      document.getElementById("Answer").innerHTML = answe;
      document.getElementById("question_ID").innerHTML = ids;
      document.getElementById("exam_name").innerHTML = "Exam: " + "newExam";
      document.getElementById("username").innerHTML = "Student: " + "student";
      document.getElementById("points").innerHTML = "Points: " + totalPoints;

      document.getElementById("def_comments").inninnerHTML = defComments;
      var fc = document.getElementById("function_comments");
     // fc.innerHTML(functionComments);

      document.getElementById("parameter_comments").innerHTML = parameterComments;
      document.getElementById("constraint_comments").innerHTML = constraintComments;
      document.getElementById("colon_comments").innerHTML = colonComments;
      //document.getElementById("Total_Results").innerHTML = totalResults;
      //document.getElementById("Total_Status").innerHTML = Total_Points;
     // console.log(functionPoints)
      document.getElementById("def_points").value = defPoints;
      document.getElementById("function_points").value = functionPoints;
      console.log(response.functionPoints);
      document.getElementById("parameter_points").value = parameterPoints;
      document.getElementById("constraint_points").value = constraintPoints;
      document.getElementById("colon_points").value = colonPoints;
      document.getElementById("total_points").value = data.TCPoints;

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
       document.getElementById("comments").value;
       document.getElementById("def_points").value;
       document.getElementById("def_comments").innerHTML;
       document.getElementById("function_points").value;
       document.getElementById("function_comments").innerHTML;
       document.getElementById("parameter_points").value;
       document.getElementById("parameter_comments").innerHTML;
       document.getElementById("constraint_points").value;
       document.getElementById("constraint_comments").innerHTML;
       document.getElementById("colon_points").value;
       document.getElementById("colon_comments").innerHTML;

       document.getElementById("Input_1_Comments").innerHTML=tcc1;
       document.getElementById("Input_2_Comments").innerHTML=tcc2;
       document.getElementById("Input_3_Comments").innerHTML=tcc3;
       document.getElementById("Input_4_Comments").innerHTML=tcc4;
       document.getElementById("Input_5_Comments").innerHTML=tcc5;

       document.getElementById("Output_1_Comments").innerHTML=occ1;
       document.getElementById("Output_2_Comments").innerHTML=occ2;
       document.getElementById("Output_3_Comments").innerHTML=occ3;
       document.getElementById("Output_4_Comments").innerHTML=occ4;
       document.getElementById("Output_5_Comments").innerHTML=occ5;

       document.getElementById("Testcase_1_Points").value=tcp1;
       document.getElementById("Testcase_2_Points").value=tcp2;
       document.getElementById("Testcase_3_Points").value=tcp3;
       document.getElementById("Testcase_4_Points").value=tcp4;
       document.getElementById("Testcase_5_Points").value=tcp5;

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
      save_content(increment_question);
      increment_question--;
      document.getElementById("comments").value = comment_content[increment_question];
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
    comment_content[increment_question] = document.getElementById("comments").value;

    def_comments[increment_question] =
    document.getElementById("def_comments").innerHTML;
    function_comments[increment_question] = document.getElementById("function_comments").innerHTML;
    parameter_comments[increment_question] = document.getElementById("parameter_comments").innerHTML;
    constraint_comments[increment_question] = document.getElementById("constraint_comments").innerHTML;
    colon_comments[increment_question] = document.getElementById("colon_comments").innerHTML;

    def_points[increment_question] =
    document.getElementById("def_points").value;
    function_points[increment_question] = document.getElementById("function_points").value;
    parameter_points[increment_question] = document.getElementById("parameter_points").value;
    constraint_points[increment_question] = document.getElementById("constraint_points").value;
    colon_points[increment_question] = document.getElementById("colon_points").value;

    Input_1_Comments[increment_question] = document.getElementById("Input_1_Comments").innerHTML;
    Input_2_Comments[increment_question] =
    document.getElementById("Input_2_Comments").innerHTML;
    Input_3_Comments[increment_question] =
    document.getElementById("Input_3_Comments").innerHTML;
    Input_4_Comments[increment_question] =
    document.getElementById("Input_4_Comments").innerHTML;
    Input_5_Comments[increment_question] =
    document.getElementById("Input_5_Comments").innerHTML;

    Output_1_Comments[increment_question] =
    document.getElementById("Output_1_Comments").innerHTML;
    Output_2_Comments[increment_question] =
    document.getElementById("Output_2_Comments").innerHTML;
    Output_3_Comments[increment_question] =
    document.getElementById("Output_3_Comments").innerHTML;
    Output_4_Comments[increment_question] =
    document.getElementById("Output_4_Comments").innerHTML;
    Output_5_Comments[increment_question] =
    document.getElementById("Output_5_Comments").innerHTML;

    Testcase_1_Points[increment_question] =
    document.getElementById("Testcase_1_Points").value;
    Testcase_2_Points[increment_question] =
    document.getElementById("Testcase_2_Points").value;
    Testcase_3_Points[increment_question] =
    document.getElementById("Testcase_3_Points").value;
    Testcase_4_Points[increment_question] =
    document.getElementById("Testcase_4_Points").value;
    Testcase_5_Points[increment_question] =
    document.getElementById("Testcase_5_Points").value;

    question_ID[increment_question] = document.getElementById("question_ID").innerHTML;

    for (var j = 0; j < total_points.length; j++)
    {
      testcase_points[increment_question][j] = document.getElementById("point_input" + (j + 4)).value;
    }
  }
///////////////////////////////////////////////////////////////////////
// Submit reviewed and graded exam with comments
function submit_exam()
{
  save_content(increment_question);
  var username = document.getElementById("username").innerHTML;
  var Exam_Name = document.getElementById("exam_name").innerHTML;
/*
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

    for (var j = 0; j < testcase_points[i].length; j++)
    {
      total_points[i] += parseInt(testcase_points[i][j]);
    }
  }

  var test_string = "";

  for (var i = 0; i < size; i++)
  {
    for (j = 0; j < testcase_points[i].length; j++)
    {
      test_string += testcase_points[i][j];

      if (j != testcase_points[i].length-1)
      {
        test_string += "~";
      }
    }
    if (i != size - 1)
    {
      test_string += ",";
    }
  }
*/
  send_data.append('operation', 'Professor_Submit_Exam');
  send_data.append('Exam_Name', Exam_Name);
  send_data.append('Username', username);
  send_data.append('def_comments', def_comments);
  send_data.append('def_points', def_points);
  send_data.append('function_comments', function_comments);
  send_data.append('function_points', function_points);
  send_data.append('parameter_comments', parameter_comments);
  send_data.append('parameter_points', parameter_points);
  send_data.append('constraint_comments', constraint_comments);
  send_data.append('constraint_points', constraint_points);
  send_data.append('colon_comments', colon_comments);
  send_data.append('colon_points', colon_points);
  send_data.append('total_points', total_points);
  send_data.append('input_1_comments', tcc1);
  send_data.append('input_2_comments', tcc2);
  send_data.append('input_3_comments', tcc3);
  send_data.append('input_4_comments', tcc4);
  send_data.append('input_5_comments', tcc5);
  send_data.append('output_1_comments', occ1);
  send_data.append('output_2_comments', occ2);
  send_data.append('output_3_comments', occ3);
  send_data.append('output_4_comments', occ4);
  send_data.append('output_5_comments', occ5);
  send_data.append('testcase_points_1', tcp1);
  send_data.append('testcase_points_2', tcp2);
  send_data.append('testcase_points_3', tcp3);
  send_data.append('testcase_points_4', tcp4);
  send_data.append('testcase_points_5', tcp5);
  send_data.append('total points', totalPoints);
  send_data.append('testcase points', data.TCPoints);
  send_data.append('comments', document.getElementById("comments").value);
  send_data.append('Question_IDs', question_ID);
  send_data.append('grade', document.getElementById("grade").value);

  for (var pair of send_data.entries()) {
   console.log(pair[0]+ ', '+ pair[1]);
  }

  const url = 'https://web.njit.edu/~kjk42/CS490Test/releaseExam.php';

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
/*{
  comment_content[increment_question] = document.getElementById("comments").value;

  def_comments[increment_question] =
  document.getElementById("def_comments").innerHTML;
  function_comments[increment_question] = document.getElementById("function_comments").innerHTML;
  parameter_comments[increment_question] = document.getElementById("parameter_comments").innerHTML;
  constraint_comments[increment_question] = document.getElementById("constraint_comments").innerHTML;
  colon_comments[increment_question] = document.getElementById("colon_comments").innerHTML;

  def_points[increment_question] =
  document.getElementById("def_points").value;
  function_points[increment_question] = document.getElementById("function_points").value;
  parameter_points[increment_question] = document.getElementById("parameter_points").value;
  constraint_points[increment_question] = document.getElementById("constraint_points").value;
  colon_points[increment_question] = document.getElementById("colon_points").value;

  Input_1_Comments[increment_question] = document.getElementById("Input_1_Comments").innerHTML;
  Input_2_Comments[increment_question] =
  document.getElementById("Input_2_Comments").innerHTML;
  Input_3_Comments[increment_question] =
  document.getElementById("Input_3_Comments").innerHTML;
  Input_4_Comments[increment_question] =
  document.getElementById("Input_4_Comments").innerHTML;
  Input_5_Comments[increment_question] =
  document.getElementById("Input_5_Comments").innerHTML;

  Output_1_Comments[increment_question] =
  document.getElementById("Output_1_Comments").innerHTML;
  Output_2_Comments[increment_question] =
  document.getElementById("Output_2_Comments").innerHTML;
  Output_3_Comments[increment_question] =
  document.getElementById("Output_3_Comments").innerHTML;
  Output_4_Comments[increment_question] =
  document.getElementById("Output_4_Comments").innerHTML;
  Output_5_Comments[increment_question] =
  document.getElementById("Output_5_Comments").innerHTML;

  Testcase_1_Points[increment_question] =
  document.getElementById("Testcase_1_Points").value;
  Testcase_2_Points[increment_question] =
  document.getElementById("Testcase_2_Points").value;
  Testcase_3_Points[increment_question] =
  document.getElementById("Testcase_3_Points").value;
  Testcase_4_Points[increment_question] =
  document.getElementById("Testcase_4_Points").value;
  Testcase_5_Points[increment_question] =
  document.getElementById("Testcase_5_Points").value;

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
}*/

function release_exam()
{

  var form_data = new FormData();
  form_data.append('operation', "Release_Exam");
  form_data.append('EXAM_NAME', exam_name);
  form_data.append('counter', increment_question);

  for (var key of form_data.entries()) {
   console.log(key[0]+ ', '+ key[1]);
  }

  const url = 'https://web.njit.edu/~kjk42/CS490Test/mRch.php';

  const options = {
    method: 'POST',
    body: form_data
  };

  fetch(url, options).then(promised_results => promised_results.json()).then(data => {
    console.log(data)
    document.getElementById("release_exam_status").innerHTML = "Exam was released for student to see their results!";
});
}
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
