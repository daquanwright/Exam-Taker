<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Create Exams for students to take</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div class="column">

  <p>Search</p>

  <label for="Type">Type:</label>

  <select id="Question_Bank_Type" name="Type">
    <option value="All">All</option>
    <option value="Loop">Loop</option>
    <option value="Print">Print</option>
    <option value="Math">Math</option>
    <option value="String">String</option>
    <option value="Recursion">Recursion</option>
  </select>

  <br><br>

  <label for="Difficulty">Difficulty:</label>

  <select id="Question_Bank_Difficulty" name="Difficulty">
    <option value="All">All</option>
    <option value="Easy">Easy</option>
    <option value="Medium">Medium</option>
    <option value="Hard">Hard</option>
  </select>

  <br><br>

  <label for="Constraints">Constraints:</label>

  <select id="Question_Bank_Constraints" name="Constraints">
    <option value="All">All</option>
    <option value="None">None</option>
    <option value="For">For</option>
    <option value="While">While</option>
    <option value="Print">Print</option>
  </select>

  <br><br>

  Keyword: <input name="Question_Bank_Keyword" id="Question_Bank_Keyword">
  <input type="hidden" id="Question_Bank_Keyword" name="Question_Bank_Keyword" value="All">

  <br>

  <button class="submit" onclick="search_question()">Search Question</button>

  <div id="question_bank_table_position">
    <table id="question_bank">
      <tr>
        <th>ID: </th>
        <th>Question: </th>
        <th>Type: </th>
        <th>Difficulty: </th>
        <th>Constraints: </th>
      </tr>
    </table>
  </div> <!-- question_bank_table_position -->

  <p id="question_count"></p>

  <br>

  <a href="home.php" id="back">Back</a>

  </div> <!-- Search Question Column -->

<!-- EXAM STARTS HERE!! -->

  <div class="column">

    Exam Name: <input type="text" id="Exam_Name">

    <br><br><br><hr><br><br>

    <table id="exam_questions">
      <tr>
        <th>ID: </th>
        <th>Question: </th>
        <th>Type: </th>
        <th>Difficulty: </th>
        <th>Constraints: </th>
        <th>Points</th>
      </tr>
    </table>

    <p id="exam_question_count"></p>

    <br>

    <button class="submit" onclick="create_exam()">Create Exam</button>

    <p id="submit_status"></p>

  </div> <!-- Create Exam Column -->

<!-- EXAM ENDS HERE!! -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare initial variables and arrays required for fetch operations
  var question_ID = [];
  var question_content = [];
  var question_type = [];
  var question_difficulty = [];
  var question_constraint = [];

  var points = [];

  var response;

  var size = 0;
  var exam_size = 0;
///////////////////////////////////////////////////////////////////////
  // Search question bank for existing questions
  search_question();
  function search_question() {

    var Question_Bank_Type = document.getElementById("Question_Bank_Type").value;
    var Question_Bank_Difficulty = document.getElementById("Question_Bank_Difficulty").value;
    var Question_Bank_Constraints = document.getElementById("Question_Bank_Constraints").value;
    var Question_Bank_Keyword = document.getElementById("Question_Bank_Keyword").value;

    var form_data = new FormData();
    form_data.append('operation', "Question_Search");
    form_data.append('Type', Question_Bank_Type);
    form_data.append('Difficulty', Question_Bank_Difficulty);
    form_data.append('Constraints', Question_Bank_Constraints);
    form_data.append('Keyword', Question_Bank_Keyword);
/*
    for (var pair of form_data.values()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }
*/
    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRSearch.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;
      if (response == "Results Not Present!") {
        size = 0;
        empty_tables();
      }
      else {
        size = response.length;
        populate_tables(size);
        document.getElementById("question_count").innerHTML = "Questions Found: " + size;
      }
    });
  }
///////////////////////////////////////////////////////////////////////
  // Add questions to exam
  function add_question(i)
  {
    var table = document.getElementById("question_bank");
    var rows = table.children[0];

    question_ID.push(rows.children[i].children[0].innerHTML);
    question_content.push(rows.children[i].children[1].innerHTML);
    question_type.push(rows.children[i].children[2].innerHTML);
    question_difficulty.push(rows.children[i].children[3].innerHTML);
    question_constraint.push(rows.children[i].children[4].innerHTML);

    exam_size++;

    var table = document.getElementById("exam_questions");
    var row = table.insertRow(exam_size);
    var ID = row.insertCell(0);
    var Question = row.insertCell(1);
    var Type = row.insertCell(2);
    var Difficulty = row.insertCell(3);
    var Constraints = row.insertCell(4);
    var test = row.insertCell(5);
    var Points = document.createElement("Input");
    var Points_Name = "Point_Input" + (exam_size - 1);
    Points.setAttribute("id", Points_Name);
    Points.size = "5";
    test.appendChild(Points);

    var test_2 = row.insertCell(6);
    var button = document.createElement("Button");
    button.setAttribute("class", "button");
    button.setAttribute("onclick", "remove_question(" + (exam_size - 1) + ")");
    button.innerHTML = "X";
    test_2.appendChild(button);

    ID.innerHTML = question_ID[exam_size - 1];
    Question.innerHTML = question_content[exam_size - 1];
    Type.innerHTML = question_type[exam_size - 1];
    Difficulty.innerHTML = question_difficulty[exam_size - 1];

    if (question_constraint[exam_size - 1] == "")
    {
      Constraints.innerHTML = "None";
    }
    else
    {
      Constraints.innerHTML = question_constraint[exam_size - 1];
    }
  }
///////////////////////////////////////////////////////////////////////
  // Remove questions from exam
  function remove_question(i)
  {
    var table = document.getElementById("exam_questions").children[0];
    table.removeChild(table.children[i + 1]);

    question_ID.splice(i, 1);
    question_content.splice(i, 1);
    question_type.splice(i, 1);
    question_difficulty.splice(i, 1);
    question_constraint.splice(i, 1);

    exam_size--;

    for (var j = i; j < exam_size; j++)
    {
      var input = table.children[j + 1].children[5].children[0];
      input.setAttribute("ID", "Point_Input" + j);
      var button = table.children[j + 1].children[6].children[0];
      button.setAttribute("onclick", "remove_question(" + (j) + ")" );
    }

  }
///////////////////////////////////////////////////////////////////////
  // Create exams and send to exam bank
  function create_exam()
  {
    for (var i = 0; i < exam_size; i++)
    {
      points.push(document.getElementById("Point_Input" + i).value);
    }

    var form_data = new FormData();
    form_data.append('operation', "Add_Exam");
    form_data.append('Exam_Name', document.getElementById("Exam_Name").value);
    form_data.append('Question_IDs', question_ID);
    form_data.append('Points', points);

    for (var key of form_data.entries()){
        console.log(key[0]+ ', ' +key[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRc.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      document.getElementById("submit_status").innerHTML = "Exam was created and fired off!!!";
    });
  }
///////////////////////////////////////////////////////////////////////
  // Populate tables with question bank data
  function populate_tables(j)
  {
    empty_tables();
    var table = document.getElementById("question_bank");
    var initial_value = j - 1;

    for (var i = 0; i < j; i++)
    {
      var row = table.insertRow(1);

      var data = response[i];
      var ID = row.insertCell(0);
      var Question = row.insertCell(1);
      var Type = row.insertCell(2);
      var Difficulty = row.insertCell(3);
      var Constraints = row.insertCell(4);
      var test = row.insertCell(5);
      var button = document.createElement("Button");
      button.setAttribute("class", "button");
      button.setAttribute("onclick", "add_question(" + (initial_value + 1) + ")" );
      initial_value--;
      button.innerHTML = "Add";
      test.appendChild(button);

      ID.innerHTML = data["ID"];
      Question.innerHTML = data["Question"];
      Type.innerHTML = data["Type"];
      Difficulty.innerHTML = data["Difficulty"];
      Constraints.innerHTML = data["Constraints"];

      if (response[i].Constraints == "")
      {
        Constraints.innerHTML = "None";
      }
      else
      {
        Constraints.innerHTML = response[i].Constraints;
      }
    }
  }
///////////////////////////////////////////////////////////////////////
  // Empty tables with question bank data
  function empty_tables()
  {
    var table = document.getElementById("question_bank");
    var rows = table.children[0];
    var length = rows.children.length;

    for (var j = 1; j < length; j++)
    {
      rows.removeChild(rows.children[1]);
    }
  }
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
