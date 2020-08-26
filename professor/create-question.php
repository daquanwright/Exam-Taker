<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Create Questions For Exams</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div class="column">

  <p>Question:</p>

  <textarea rows="7" cols="50" id="Question" name="Question"></textarea>

  <br><br>

  <label for="Function Name">Function Name:</label>
  <input type="text" id="Function" name="Function">

  <br><br>

  <label for="Type">Choose Question Type:</label>

  <select id="Type" name="Type">
    <option value="Loop">Loop</option>
    <option value="Print">Print</option>
    <option value="Math">Math</option>
    <option value="String">String</option>
    <option value="Recursion">Recursion</option>
  </select>

  <br><br>

  <label for="Difficulty">Choose Question Difficulty:</label>

  <select id="Difficulty" name="Difficulty">
    <option value="Easy">Easy</option>
    <option value="Medium">Medium</option>
    <option value="Hard">Hard</option>
  </select>

  <br><br>

  <label for="Constraints">Constraints:</label>

  <select id="Constraints" name="Constraints">
    <option value="None">None</option>
    <option value="For">For</option>
    <option value="While">While</option>
    <option value="Print">Print</option>
  </select>

  <br><br>

  <label for="Parameters">Parameters:</label>
  <input type="text" id="Parameters" name="Parameters">

  <br><br>

  <table id="Test_Cases" name="Test_Cases">
    <tr>
      <td>
        Test Case 1
      </td>
      <td>
        Input: <input id="input0" name="input0">
      </td>
      <td>
        Output: <input id="output0" name="output0">
      </td>
    </tr>
    <tr>
      <td>
        Test Case 2:
      </td>
      <td>
        Input: <input id="input1" name="input1">
      </td>
      <td>
        Output: <input id="output1" name="output1">
      </td>
    </tr>
    <tr>
      <td>
        Test Case 3:
      </td>
      <td>
        Input: <input id="input2" name="input2">
      </td>
      <td>
        Output: <input id="output2" name="output2">
      </td>
    </tr>
    <tr>
      <td>
        Test Case 4:
      </td>
      <td>
        Input: <input id="input3" name="input3">
      </td>
      <td>
        Output: <input id="output3" name="output3">
      </td>
    </tr>
    <tr>
      <td>
        Test Case 5:
      </td>
      <td>
        Input: <input id="input4" name="input4">
      </td>
      <td>
        Output: <input id="output4" name="output4">
      </td>
    </tr>
    <tr>
      <td>
        Test Case 6:
      </td>
      <td>
        Input: <input id="input5" name="input5">
      </td>
      <td>
        Output: <input id="output5" name="output5">
      </td>
    </tr>
  </table>

  <button class="submit" onclick="create_testcase()">Add Test Case</button>
  <button class="submit" onclick="remove_testcase()">Remove Test Case</button>

  <br>

  <button type="submit" name="submit" class="submit" onclick="create_question()">Create Question</button>

  <p id="submit_status"></p>

  <br><br><br>

  <a href="home.php" id="back">Back</a>

  </div> <!-- Create Question Column -->

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
  <!-- <input type="hidden" id="Question_Bank_Keyword" name="Question_Bank_Keyword" value="All"> -->

  <br>

  <button class="submit" onclick="search_question()">Search Question</button>

  <div id="question_bank_table_position">
    <table id="question_bank">
      <tr>
        <th>ID: </th>
        <th>Name: </th>
        <th>Question: </th>
        <th>Type: </th>
        <th>Difficulty: </th>
        <th>Constraints: </th>
      </tr>
    </table>
  </div> <!-- question_bank_table_position -->

  <p id="question_count"></p>

  </div> <!-- Search Question Column -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare variables and arrays required for fetch operations
  var question_ID = [];
  var question_content = [];
  var question_type = [];
  var question_difficulty = [];
  var testcase_count = 6;
  var response;

  var size = 0;

  var test;
  var test_2;
///////////////////////////////////////////////////////////////////////
// Create question and send to question bank
function create_question() {

  search_question();
  // Send form data to the server for each category
  var Question = document.getElementById("Question").value;
  var Function = document.getElementById("Function").value;
  var Type = document.getElementById("Type").value;
  var Difficulty = document.getElementById("Difficulty").value;
  var Parameters = document.getElementById("Parameters").value;
  var Constraints = document.getElementById("Constraints").value;

  var Test_Cases = [];
  var Inputs = [];
  var Outputs = [];

  // Verify correct amount of test cases for
  // each question and stack Inputs and Outputs
  // onto the end of the array
  for (var i = 0; i < testcase_count; i++)
  {
    var input = "input" + i;
    var output = "output" + i;
    Test_Cases.push([document.getElementById(input).value, document.getElementById(output).value]);
    Inputs.push(document.getElementById(input).value.replace(/,/g, "~"));
    Outputs.push(document.getElementById(output).value.replace(/,/g, "~"));
  }

  // Check length of test cases and perform
  // a global replacement on ',' for '~'
  for (var i = 0; i < Test_Cases.length; i++) {
    Test_Cases[i][0] = Test_Cases[i][0].replace(/,/g, "~");
    Test_Cases[i][1] = Test_Cases[i][1].replace(/,/g, "~");
  }

  // Check length of inputs and perform
  // a global replacement on ',' for '~'
  // for Inputs and Outputs
  for (var i = 0; i < Inputs.length; i++) {
    Inputs[i] = Inputs[i].replace(/,/g, "~");
    Outputs[i] = Outputs[i].replace(/,/g, "~");
  }

  // Construct sets of key/value pairs
  // that represent our form fields and values
  // to be sent asychronously to the server
  var question_content = new FormData();
  question_content.append('operation', "Add_Question");
  question_content.append('Question', Question);
  question_content.append('Function', Function);
  question_content.append('Type', Type);
  question_content.append('Difficulty', Difficulty);
  question_content.append('Parameters', Parameters);
  question_content.append('Test_Cases', Test_Cases);
  question_content.append('Inputs', Inputs);
  question_content.append('Outputs', Outputs);
  question_content.append('Constraints', Constraints);

  for (var key of question_content.entries()) {
     console.log(key[0]+ ', '+ key[1]);
    }

  test = question_content;
  test_2 = Test_Cases;

//console.log(test);
  // Construct URL defined by parameters
  const url = 'https://web.njit.edu/~dw269/beta/front-end.php';

  // Construct options object as a secondary argument
  const options = {
    method: 'POST',
    body: question_content
  };

  // Create Promise object to hold results for completion
  // or failure of our asychronous operation and its results
  fetch(url, options).then(promised_results => promised_results.json()).then(data => {
    console.log(data)
    search_question();
    document.getElementById("submit_status").innerHTML = "Question sent to question bank successfully!";
  });
}
///////////////////////////////////////////////////////////////////////
  // Search question bank for existing questions
  search_question();
  function search_question() {

    var Type = document.getElementById("Question_Bank_Type").value;
    var Difficulty = document.getElementById("Question_Bank_Difficulty").value;
    var Constraints = document.getElementById("Question_Bank_Constraints").value;
    var Keyword = document.getElementById("Question_Bank_Keyword").value;

    var form_data = new FormData();
    form_data.append('operation', "Question_Search");
    form_data.append('Type', Type);
    form_data.append('Difficulty', Difficulty);
    form_data.append('Constraints', Constraints);
    form_data.append('Keyword', Keyword);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

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
  // Add additional test cases
  function create_testcase()
  {
    if (testcase_count < 6)
    {
      var table = document.getElementById("Test_Cases");
      var row = table.insertRow(testcase_count);
      var cell_1 = row.insertCell(0);
      var cell_2 = row.insertCell(1);
      var cell_3 = row.insertCell(2);
      var cell_4 = row.insertCell(3);
      var cell_5 = row.insertCell(4);
      var cell_6 = row.insertCell(5);
      cell_1.innerHTML = "Test Case " + (testcase_count + 1) + ":";

      var test = document.createElement("Input");
      test.id = "Input" + testcase_count;
      test.name = "Input" + testcase_count;
      test.size = 20;
      cell_2.innerHTML = "Input: <br>";
      cell_2.appendChild(test);

      var Output = document.createElement("Input");
      Output.id = "Output" + testcase_count;
      Output.name = "Output" + testcase_count;
      Output.size = 20;
      cell_3.innerHTML = "Output: <br>";
      cell_3.appendChild(Output);
      testcase_count++;
    }
  }
///////////////////////////////////////////////////////////////////////
  // Remove unnecessary test cases
  function remove_testcase()
  {
    if (testcase_count > 2)
    {
      var table = document.getElementById("Test_Cases").children[0];
      table.removeChild(table.lastElementChild);
      testcase_count--;
    }
  }
///////////////////////////////////////////////////////////////////////
  // Populate tables with question bank data
  function populate_tables(j)
  {
    empty_tables();
    var table = document.getElementById("question_bank");

    for (var i = 0; i < j; i++)
    {
      var table = document.getElementById("question_bank");
      var row = table.insertRow(1);

      var data = response[i];
      var ID = data["ID"];
      var Name = data["Name"];
      var Question = data["Question"];
      var Type = data["Type"];
      var Difficulty = data["Difficulty"];
      var Constraints = data["Constraints"];

      row.insertCell(0).innerHTML = ID;
      row.insertCell(1).innerHTML = Name;
      row.insertCell(2).innerHTML = Question;
      row.insertCell(3).innerHTML = Type;
      row.insertCell(4).innerHTML = Difficulty;
      row.insertCell(5).innerHTML = Constraints;
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
