<!-- Daquan Wright - Front-end -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="3-tier web application for CS 490">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Students take exams to be graded and reviewed</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div id="container">

  <div id="exam_column">

    <p hidden id="username">Test</p>

    <p id="exam_name"></p>

    <p id="question"></p>

    <p id="points"></p>

    Answer: <br><textarea rows="20" cols="100" name="Answer" id="Answer" onkeydown="insert_tab(this, event);"/></textarea>

    <p id="IDs"></p>

    <br>

    <button class="submit" onclick="decrement_question()">--</button>
    <button class="submit" onclick="increment_questions()">++</button>

    <p id="question_count"></p>

    <button class="submit" onclick="submit_exam()">Submit Exam</button>

    <p id="submit_status"></p>

  </div> <!-- Take Exam Column -->

</div> <!-- container -->

<script type="text/javascript">
///////////////////////////////////////////////////////////////////////
  // Declare initial variables and arrays required for fetch operations
  var question_content = [];
  var answer_content = [];

  // this line needs to be changed in your code
  var question_ID = [];
  var answer;
  var response;

  var size;
  var exam_size;

  var increment_question = 0;

  var page = 1;
  var exam_page = 1;
///////////////////////////////////////////////////////////////////////
  // Retrieve exam questions for student to answer
  function retrieve_questions() {
    var Exam_Name = document.getElementById("exam_name").innerHTML;

    var form_data = new FormData();
    form_data.append('operation', "Retrieve_Questions");
    ///////////////// this needs to be not hardcoded
    form_data.append('Exam_Name', Exam_Name);

    for (var key of form_data.entries()) {
       console.log(key[0]+ ', '+ key[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/mRrq.php';

    const options = {
      method: 'POST',
      body: form_data
      // headers are probably ok i just commented them out in the beginning
    //  headers: {
      //  'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
      //}
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;

      size = response.length;

      for (var i = 0; i < size; i++)
      {
        answer_content[i] = "";
       // question_ID[i]= data.ID;
        //console.log(question_ID[i]);
      }
      getCount();
      document.getElementById("question_count").innerHTML = "Question " + page + " of " + size;
    });
  }
  retrieve_questions();
///////////////////////////////////////////////////////////////////////
  // Submit exam results
  function submit_exam()
  {
    save_answer();
    var username = document.getElementById("username").innerHTML;
    var Exam_Name = document.getElementById("exam_name").innerHTML;

    var answers = answer_content;

    for (var i = 0; i < answers.length; i++)
    {
      answers[i] = answers[i].replace(/,/g, "~");
    }

    var form_data = new FormData();
    form_data.append('operation', "Student_Submit_Exam");
    form_data.append('Exam_Name', Exam_Name);
    form_data.append('Username', username);
    form_data.append('Answers', answer_content);
    // the line below needs to be adjusted
    form_data.append('IDs', question_ID);

    for (var pair of form_data.entries()) {
     console.log(pair[0]+ ', '+ pair[1]);
    }

    const url = 'https://web.njit.edu/~kjk42/CS490Test/front/front-end5.php';

    const options = {
      method: 'POST',
      body: form_data
    };

    fetch(url, options).then(promised_results =>
    promised_results.json()).then(data => {
      console.log(data)
      response = data;

      document.getElementById("submit_status").innerHTML = "Thank you for finishing your exam, your results will soon be released!";
     // location.replace("https://web.njit.edu/~dw269/functional/student/home.php");
    });
  }
///////////////////////////////////////////////////////////////////////
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
      //IDs = data.ID;
      points = data.Points;
      question_ID[i]= data.ID;
       // console.log(question_ID[i]);
    }
      populate_questions();
  }
///////////////////////////////////////////////////////////////////////
  function populate_questions()
  {
    if (increment_question < size)
   {
       // don't need anything commented out here, probably best to save a copy in case though
     data = response[increment_question];
     //console.log(increment_question);
     // var questionCount = increment_question;

     //var question_ID = [];
     //IDs = data.ID;
     quest = question_content = data.Question;
     //console.log(quest);
     points = data.Points;
     ids = data.IDs

     document.getElementById("exam_name").innerHTML = "Exam: " + data.Exam_Name;
     document.getElementById("IDs").innerHTML = data.ID;
     document.getElementById("question").innerHTML = "Question: " + quest;
     document.getElementById("points").innerHTML = "Points: " + points;
     document.getElementById("question_count").innerHTML = "Question " + page + " of " + size;
      //question_ID[increment_question] = document.getElementById("IDs").value;
    //  document.getElementById("IDs").innerHTML = "Points: " + ids;
      //console.log(document.getElementById("IDs").value);

    }
  }



///////////////////////////////////////////////////////////////////////
  // Cycle up question list
   function increment_questions()
  {
    if (increment_question < size - 1)
    {
      // it has to go in this specific order for the first/last answer/question to match
       document.getElementById("IDs").value= question_ID[increment_question];
      save_answer();
      increment_question++;

     document.getElementById("Answer").value= answer_content[increment_question];
     //document.getElementById("IDs").value= question_ID[increment_question];
     //console.log(document.getElementById("IDs").value)//= question_ID[increment_question]);

      page++;
      populate_questions();
    }

  }
///////////////////////////////////////////////////////////////////////
  // Cycle down question list
  function decrement_question()
  {
    if (increment_question > 0)
    {
        //decrement should be ok the way it is
      save_answer();
      increment_question--;
      document.getElementById("Answer").value = answer_content[increment_question];
      document.getElementById("IDs").value= question_ID[increment_question];
      page--;
      populate_questions();
    }
  }


///////////////////////////////////////////////////////////////////////
  // Save the contents of student submitted results
  function save_answer()
  {
      //dont need anything i commented here, pretty sure that was all extra stuff i added
    answer_content[increment_question] = document.getElementById("Answer").value;
    //question_ID[increment_question] = document.getElementById("IDs").value;
    //console.log(question_ID[increment_question]= document.getElementById("IDs").value);
  }
///////////////////////////////////////////////////////////////////////
  // Activate event upon user typing
    var textareas = document.getElementsByTagName('Answer');
    var count = textareas.length;

    for (var i = 0; i < count; i++)
    {
      textareas[i].onkeydown = function(e)
      {
        if (e.keyCode == 9 || e.which == 9)
        {
          e.preventDefault();
          var s = this.selectionStart;
          this.value = this.value.substring(0, this.selectionStart) + "\t" + this.value.
          substring(this.selectionEnd);
          this.selectionEnd = s + 1;
        }
      }
    }
///////////////////////////////////////////////////////////////////////
  // Create tab for Python coding in textareas
  function insert_tab(object, event)
  {
  	var keyCode = event.keyCode ? event.keyCode : event.charCode ? event.charCode : event.which;
	  if (keyCode == 9 && !event.shiftKey && !event.ctrlKey && !event.altKey)
	{
		var os = object.scrollTop;
		if (object.setSelectionRange)
		{
			var ss = object.selectionStart;
			var se = object.selectionEnd;
			object.value = object.value.substring(0, ss) + "\t" + object.value.substr(se);
			object.setSelectionRange(ss + 1, ss + 1);
			object.focus();
		}
		else if (object.createTextRange)
		{
			document.selection.createRange().text = "\t";
			event.return_value = false;
		}
		object.scrollTop = os;
		if (event.preventDefault)
		{
			event.preventDefault();
		}
		return false;
	}
	return true;
}
///////////////////////////////////////////////////////////////////////
</script>

</body>
</html>
