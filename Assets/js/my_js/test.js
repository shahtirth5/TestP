var questionArray;
$(document).ready(function () {
    $("#button_1").click();
    var test_id = $("#test_id").html(); 
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "test_id="+test_id+"&manage=test_questions_json",
    }).done(function(response){
        if(response === "NoSession"){
            $("body").html("<h1>404 Page Not Found</h1>");
        } else{
            questionArray = JSON.parse(response);
            console.table(questionArray);
            makeUIFromArray(questionArray);
            startTimer(test_id);
            setInterval(function(){
                updateTimer(test_id);
            } , 2000);
        }
    });
});


function makeUIFromArray(questionArray){
    initializeQuestions(questionArray);
    makeButtons(questionArray);
    for(var i = 0 ; i < questionArray.length ; i++){
        if(questionArray[i].Selected_Option != -1){
            var option = parseInt(questionArray[i].Selected_Option);
            $("#question_"+(i+1)+"_radio_option_"+option).prop("checked" , true);
        }
    }
}


function startTimer(test_id){
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "test_id="+test_id+"&manage=test_time_left",
    }).done(function(response){
        var time = parseInt(response);
        var timer = new Timer();
        timer.start({countdown: true, startValues: {seconds: time}});
        $('#timer').html(timer.getTimeValues().toString());
        timer.addEventListener('secondsUpdated', function (e) {
            $('#timer').html(timer.getTimeValues().toString());
        });
        timer.addEventListener('targetAchieved', function (e) {
            computeAndStoreMarks();
        });
    });
}

function updateTimer(test_id){
    var timeString = $("#timer").html();
    var timeInSeconds = convertTimeToSec(timeString);
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "test_id="+test_id+"&current_time="+timeInSeconds+"&manage=test_update_timer",
    });
}

function convertTimeToSec(timeString){
    var timeArray = timeString.split(":");
    var hours = parseInt(timeArray[0]);
    var minutes = parseInt(timeArray[1]);
    var seconds = parseInt(timeArray[2]);

    var totalTimeInSec = seconds + (minutes * 60) + (hours * 60 * 60);
    return totalTimeInSec;
}

/****************************************************************************/
/************* Buttons Of Question Number Clicked ***************************/
/****************************************************************************/
function btnQuestionNumberClicked(event , obj){
    event.preventDefault();
    //--------- Get the number out of id string -----------
    var str = obj.id.split('_');
    var questionNo = parseInt(str[1]) ;
    //-----------------------------------------------------

    //--------- Manage The Questions Displayed ------------
    for (var i = 0; i < questionArray.length; i++) {
        $("#question_"+(i+1)).addClass("d-none");
    }
    $("#question_"+questionNo).removeClass("d-none");
    //-----------------------------------------------------

    //--------- Manage The Buttons Displayed ------------
    for(var i = 0 ; i < questionArray.length ; i++){
        if(i+1  == questionNo){
            continue;
        }
        if(questionArray[i].Selected_Option == -1){
            $("#button_"+(i+1)).removeClass("border border-white border-width-thick");
            $("#button_"+(i+1)).addClass("btn-danger");
        } else {
            $("#button_"+(i+1)).removeClass("border border-white border-width-thick");
            $("#button_"+(i+1)).addClass("btn-info");
        }
    }
    //-----------------------------------------------------

    if(questionArray[questionNo-1].Selected_Option == -1){
        $("#button_"+(questionNo)).addClass("border border-white border-width-thick");
    } else if(questionArray[questionNo-1].Selected_Option != -1){
        $("#button_"+(questionNo)).addClass("border border-white border-width-thick");
    }
    /**************************************************************/
}

function initializeQuestions(question_array){
    for (let i = 1; i <= question_array.length; i++) {
        var question_text = questionArray[i-1].Question;
        var option_1 = questionArray[i-1].Options[0].option;
        var option_2 = questionArray[i-1].Options[1].option;
        var option_3 = questionArray[i-1].Options[2].option;
        var option_4 = questionArray[i-1].Options[3].option;
        var s ;
        if(i == 1){
            s = "<div id='question_"+i+"' class='border border-secondary m-2 p-3 rounded'><div id='question_text_"+i+"'>"+"<strong>"+i+".</strong>"+question_text+"</div><div id='question_"+i+"_option_1'><input type='radio' id='question_"+i +"_radio_option_1' name='option_group_"+i+"'>"+option_1+"</div><div id='question_"+i+"_option_2'><input type='radio' id='question_"+i+"_radio_option_2' name='option_group_"+i+"'>"+option_2+"</div><div id='question_"+i+"_option_3'><input type='radio' id='question_"+i+"_radio_option_3' name='option_group_"+i+"'>"+option_3+"</div><div id='question_"+i+"_option_4'><input type='radio' id='question_"+i+"_radio_option_4' name='option_group_"+i+"'>"+option_4+"</div><button class='btn btn-primary mt-4' onclick='btnSubmitClicked(event , this ,"+i+");'>Submit Answer</button></div>";
        } else{
            s = "<div id='question_"+i+"' class='d-none border border-secondary m-2 p-3 rounded'><div id='question_text_"+i+"'>"+"<strong>"+i+".</strong>"+question_text+"</div><div id='question_"+i+"_option_1'><input type='radio' id='question_"+i+"_radio_option_1' name='option_group_"+i+"'>"+option_1+"</div><div id='question_"+i+"_option_2'><input type='radio' id='question_"+i+"_radio_option_2' name='option_group_"+i+"'>"+option_2+"</div><div id='question_"+i+"_option_3'><input type='radio' id='question_"+i+"_radio_option_3' name='option_group_"+i+"'>"+option_3+"</div><div id='question_"+i+"_option_4' ><input type='radio' id='question_"+i+"_radio_option_4' name='option_group_"+i+"'>"+option_4+"</div><button class='btn btn-primary mt-4' onclick='btnSubmitClicked(event , this , "+i+");'>Submit Answer</button></div>";
        }
        $("#test").append(s);
    }
}

function btnSubmitTestClick(event){
    event.preventDefault();
    computeAndStoreMarks();
    endTest();
}

function endTest(){
    var test_id = $("#test_id").html(); 
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "test_id="+test_id+"&manage=end_test",
    }).done(function(response){
        window.location.replace("../view_all_notifications.php");        
    });
}

function computeAndStoreMarks(){
    var marks_scored = 0;
    var totalMarks = questionArray.length;
    for (var i = 0; i < questionArray.length; i++) { 
        if(questionArray[i].Selected_Option != -1) {
            var option = parseInt(questionArray[i].Selected_Option);
            option--;
            if(questionArray[i].Options[option].is_correct == "1"){
                // console.log(questionArray[i].Question_id + " => " + questionArray[i].Selected_Option);
                marks_scored++;
            }
        }   
    }
    var test_id = $("#test_id").html(); 
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "test_id="+test_id+"&marks_scored="+marks_scored+"&total_marks="+totalMarks+"&manage=store_marks"
    });
    alert(marks_scored + " / " + totalMarks);
}

function btnSubmitClicked(event , obj , questionNo){
    event.preventDefault();
    var id = $('input[name="option_group_'+questionNo+'"]:checked')[0].id;
    console.log(id);
    var option_no = "";
    for(var i = id.length ; i >= 0 ; i--){
        if(id.charAt(i) == "_"){
            for(var j = i+1 ; j < id.length ; j++){
                option_no += id.charAt(j);
            }
            break;
        }
    }
    option_no = parseInt(option_no);
    questionArray[questionNo-1].Selected_Option = option_no;
    $(".btn-group").html("");
    makeButtons(questionArray);
    $("#button_"+(questionNo+1)).click();
    var json = JSON.stringify(questionArray);
    var test_id = $("#test_id").html();
    $.ajax({
        type: "POST",
        url: "../manageAjax.php",
        data: "question_json="+json+"&test_id="+test_id+"&manage=question_answer_submitted"
    });
}


function makeButtons(question_array){
    for(var i = 0 ; i < question_array.length ; i++){
        if(question_array[i].Selected_Option == -1){
            var string = "<label class='btn btn-danger' id='button_"+(i+1)+"' onclick='btnQuestionNumberClicked(event , this);'><input type='radio' name='options' id='option1' value='1' class='d-none'>"+(i+1)+"</label>"
            $(".btn-group").append(string);
        } else{
            var string = "<label class='btn btn-info' id='button_"+(i+1)+"' onclick='btnQuestionNumberClicked(event , this);'><input type='radio' name='options' id='option1' value='1' class='d-none'>"+(i+1)+"</label>"
            $(".btn-group").append(string);
        }
    }
}