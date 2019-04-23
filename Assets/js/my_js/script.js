/****************************** Login Page Part ***********************************************/
function LoginButtonClicked(event) {
    event.preventDefault();
    $("#login-email-div").html("");
    $("#login-password-div").html("");
    var email = $('#login-email').val();
    var password = $('#login-password').val();
    if (email === "") {
        $("#login-email-div").html("Email cannot be empty");
    }
    if (password === "") {
        $("#login-password-div").html("Password cannot be empty");
    }

    if (email !== "" && password !== "") {
        validate(email , password);
    }
}

function validate(email , password) {
    $.ajax({
        type : 'POST' ,
        data: "login-email="+ email + "&login-password=" + password + "&manage=login",
        url: "manageAjax.php"
    }).done(function(response) {
        if(response === "true"){
            $('#login-form').submit();
        } else {
            $('#login-password-div').html('Invalid Email/Password');
        }
    })
}
/*********************************************************************************************/

/****************************** Register Page Part ******************************************/
function btnRegisterClicked(event){
    event.preventDefault();
    $('#register_first_name_div').html("");
    $('#register_last_name_div').html("");
    $('#register_email_div').html("");
    $('#register_password_div').html("");
    $('#register_confirm_password_div').html("");
    var first_name = $('#register_first_name').val();
    var last_name = $('#register_last_name').val();
    var email = $('#register_email').val();
    var password = $('#register_password').val();
    var confirm_password = $('#register_confirm_password').val();

    /**
     * Validating Null Fields
     */
    if(first_name === ""){
        $('#register_first_name_div').html("First Name Cannot Be Null");
    }
    if(last_name === ""){
        $('#register_last_name_div').html("Last Name Cannot Be Null");
    }
    if(email === ""){
        $('#register_email_div').html("Email Cannot Be Null");
    }
    if(password === ""){
        $('#register_password_div').html("Password Cannot Be Null");
    }
    if(confirm_password === ""){
        $('#register_confirm_password_div').html("Confirm Password Cannot Be Null");
    }

    if(first_name != "" && last_name != "" && email != "" && password != "" && confirm_password != ""){
        // Validating Password And Confirm Password
        if(password != confirm_password){
            $('#register_confirm_password_div').html("Passwords do not match");
        } else{
            register(first_name , last_name , email , password);

        }
    }
}

function register(first_name , last_name , email , password) {
    $.ajax({
        type: "POST",
        url: "manageAjax.php",
        data: "register_first_name="+first_name+"&register_last_name="+last_name+"&register_email="+email+"&register_password="+password+"&manage=register",
    }).done(function(response){
        toastr.success('User Created');
        $('#register_first_name_div').html("");
        $('#register_last_name_div').html("");
        $('#register_email_div').html("");
        $('#register_password_div').html("");
        $('#register_confirm_password_div').html("");
    });
}

/********************************************************************************************/


/********************************* Send Notifications ****************************************/
$('#send_notification_send_to').tokenfield({
    autocomplete : {
        source : function (request , response) {
            $.ajax({
                type : 'POST' ,
                url : 'manageAjax.php' ,
                data : 'send_to='+ request.term + "&manage=send_notification_send_to" ,
                // $_POST['send_to'] = request.term;
                // $_POST['manage'] = 'send_notification_send_to';
                datatype : 'jsonp',
                success : function (data) {
                    var x = jQuery.parseJSON(data) ;
                    response(x);
                }
            });  
        } , 
        minLength : 1
    } 
});

$('#send_notification_send_to').on('tokenfield:createtoken', function (event) {
    var existingTokens = $(this).tokenfield('getTokens');
    $.each(existingTokens, function(index, token) {
        if (token.value === event.attrs.value)
            event.preventDefault();
    });
});

$('#notification-message').froalaEditor();



function BtnSendNotificationClicked(event) {
    var temp = $('#send_notification_send_to').tokenfield('getTokens');
    var sendToArray = JSON.stringify(temp);
    var content =   $('#notification-message').froalaEditor('html.get' , true , true);
    $.ajax({
        type : 'POST' ,
        data:"notification_send_to=" + sendToArray + "&notification_content=" + content+ "&manage=notifications",
        url: "manageAjax.php"
    }).done(function (response) {
        alert(response);
        $('#send_notification_send_to').tokenfield('setTokens', []);
        $('#send_notification_send_to').val('');
        $('#notification-message').froalaEditor('html.set' , "");
        toastr.success('Notification Sent');
    });
}

// $('#send_notification_send_to').autocomplete({
//     source : function (request , response) {
//         $.ajax({
//             url : 'manageAjax.php' ,
//             type : 'POST' ,
//             data : 'send_to='+request.term+"&manage=send_notification_send_to" ,
//             datatype : 'jsonp',
//             success : function (data) {
//                    var x = jQuery.parseJSON(data) ;
//                    response(x);
//             }
//         });
//     } ,
//     minLength: 1
// });

/*********************************************************************************************/

/********************************** Question Set ***********************************/
function addQuestionDiv(event){
    event.preventDefault();
    var temp = $('#addQuestions').val();
    var noOfQuestionBlocksToAdd = parseInt(temp);
    var noOfQuestionsString = $('#noOfQuestions').val();
    var noOfQuestions = parseInt(noOfQuestionsString);
    var x = noOfQuestions+1;
    noOfQuestions += noOfQuestionBlocksToAdd;
    $('#noOfQuestions').val(noOfQuestions);
    for(var i = 0 ; i < noOfQuestionBlocksToAdd ; i++){
    var string = 
        '<div class="form-group" id="question_'+ x +'">'+
        '<div class="row">'+
        '<div class="col-1 pr-0">'+x+' .</div>'+
        '<div class="col-11 pl-0">'+
        '<textarea class="form-control" id="question'+x+'" name="question1"></textarea>'+
        '</div>'+
        '</div>'+
        '<div class="row pt-3">'+
        '<div class="col-md-6">'+
        '<textarea class="form-control" id="option1_'+x+'" name="option1_1"></textarea>'+
        '</div>'+
        '<div class="col-md-6">'+
        '<textarea class="form-control" id="option2_'+x+'" name="option2_1"></textarea>'+
        '</div>'+
        '</div>'+
        '<div class="row pt-3">'+
        '<div class="col-md-6">'+
        '<textarea class="form-control" id="option3_'+x+'" name="option3_1"></textarea>'+
        '</div>'+
        '<div class="col-md-6">'+
        '<textarea class="form-control" id="option4_'+x+'" name="option4_1"></textarea>'+
        '</div>'+
        '</div>'+
        '<div class="form-check-inline">'+
        '<label class="form-check-label">'+
        '<input type="radio" class="form-check-input" name="answer_radio_'+x+'" value="1">Option 1'+
        '</label>'+
        '</div>'+
        '<div class="form-check-inline">'+
        '<label class="form-check-label">'+
        '<input type="radio" class="form-check-input" name="answer_radio_'+x+'" value="2">Option 2'+
        '</label>'+
        '</div>'+
        '<div class="form-check-inline">'+
        '<label class="form-check-label">'+
        '<input type="radio" class="form-check-input" name="answer_radio_'+x+'" value="3">Option 3'+
        '</label>'+
        '</div>'+
        '<div class="form-check-inline">'+
        '<label class="form-check-label">'+
        '<input type="radio" class="form-check-input" name="answer_radio_'+x+'" value="4">Option 4'+
        '</label>'+
        '</div>'+
        '<br><br>'+
        '</div>';

        $("#questions_input").append(string);
        x++;
    }
    $('#addQuestions').val("1");
    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
}


function AddQuestionSetClicked(event){
    var subject = $("#subjectName option:selected").val();
    var questionPaperName = $("#nameOfQuestionPaper").val();
    var questionPaperId;
    $.ajax({
        url : "../manageAjax.php" , 
        type: "POST" , 
        data : "nameOfQuestionPaper="+questionPaperName+"&questionPaperSubject="+subject+"&manage=insertQuestionPaper"
    }).done(function(response){
        questionPaperId = response;
        InsertQuestionsAndLinkWithQuestionPaper(questionPaperId);
    });        
    
    
}


function InsertQuestionsAndLinkWithQuestionPaper(questionPaperId){
    var temp = $('#noOfQuestions').val();
    var length = parseInt(temp);    
    for(var i = 1 ; i <= length ; i++){
        var question = $("#question"+i).val();
        var option1 = $("#option1_"+i).val();
        var option2 = $("#option2_"+i).val();
        var option3 = $("#option3_"+i).val();
        var option4 = $("#option4_"+i).val();
        var answer = $("input[name='answer_radio_"+i+"']:checked").val();
        if(question != "" && question != null
            && option1 != "" && option1 != null
            && option2 != "" && option2 != null
            && option3 != "" && option3 != null
            && option4 != "" && option4 != null
            && answer != "" && answer != null
        )
        {
            // AJAX MAREGA
            $.ajax({
                url:"../manageAjax.php" , 
                type: "POST" , 
                data : "question_paper_id="+questionPaperId+"&question="+question+"&option1="+option1+"&option2="+option2+"&option3="+option3+"&option4="+option4+"&answer="+answer+"&manage=insertQuestions"
            }).done(function(response){
                // alert(response);
                // console.log(response);
            });
            $('#question_'+ i ).remove();
        }
        else
        {
            if( $('#question_'+ i + ' .text-danger').length == 0 ){
                $('#question_'+ i ).append('<div class="text-danger">Fill All Datas</div>');
            }
        }
    }
}

/**************************************************************************************************************/


/********************************* SESSION DESTRUCTION ***********************************************/
function adminLogoutClicked(event){
    event.preventDefault();
    $.ajax({
        url:"../manageAjax.php" , 
        type: "POST" , 
        data : "manage=admin_logout",  
    }).done(function(response){
        window.location.href = response;
    });
}

function userLogoutClicked(event){
    event.preventDefault();
    $.ajax({
        url:"manageAjax.php" , 
        type: "POST" , 
        data : "manage=user_logout",  
    }).done(function(response){
        window.location.href = response;
    });
}
/*******************************************************************************************************/

/************************************************ GROUPS ***********************************************/
$('#group_members').tokenfield({
    autocomplete : {
        source : 
        function (request , response) {
            $.ajax({
                type : 'POST' ,
                url : '../manageAjax.php' ,
                data : 'members='+ request.term + "&manage=group_members" ,
                // $_POST['members'] = request.term;
                // $_POST['manage'] = 'group_members';
                datatype : 'jsonp',
                success : function (data) {
                    var x = jQuery.parseJSON(data) ;
                    response(x);
                }
            });  
        } , 
        minLength : 1
    } 
    
});

$('#group_members').on('tokenfield:createtoken', function (event) {
    var existingTokens = $(this).tokenfield('getTokens');
    $.each(existingTokens, function(index, token) {
        if (token.value === event.attrs.value)
            event.preventDefault();
    });
});

$('#group_description').froalaEditor();

function BtnAddGroupClicked(event){
    event.preventDefault();
    var group_name = $("#group_name").val();
    var group_description = $("#group_description").val();
    var temp = $('#group_members').tokenfield('getTokens');
    var group_members = JSON.stringify(temp);
    $.ajax({
        type : 'POST' ,
        data:"groupMembers=" + group_members + "&group_name=" + group_name + "&group_description=" + group_description +"&manage=add_group",
        url: "../manageAjax.php"
    }).done(function (response) {
        $('#group_members').tokenfield('setTokens', []);
        // $('#send_notification_send_to').val('');
        $('#group_description').froalaEditor('html.set' , "");
        toastr.success("Group Added");
    });
}


/********************************************************************************************/

/********************************* Announce Test ********************************************/

//AutoComplete and Tokenfield for Test Applicants
$('#test_applicants').tokenfield({
    autocomplete : {
        source : 
        function (request , response) {
            $.ajax({
                type : 'POST' ,
                url : '../manageAjax.php' ,
                data : 'members='+ request.term + "&manage=group_members" ,
                // $_POST['members'] = request.term;
                // $_POST['manage'] = 'group_members';
                datatype : 'jsonp',
                success : function (data) {
                    var x = jQuery.parseJSON(data) ;
                    response(x);
                }
            });  
        } , 
        minLength : 1
    } 
    
});

$('#test_applicants').on('tokenfield:createtoken', function (event) {
    var existingTokens = $(this).tokenfield('getTokens');
    $.each(existingTokens, function(index, token) {
        if (token.value === event.attrs.value)
            event.preventDefault();
    });
});


//AutoComplete and Tokenfield for Groups
$('#test_groups').tokenfield({
    autocomplete : {
        source : 
        function (request , response) {
            $.ajax({
                type : 'POST' ,
                url : '../manageAjax.php' ,
                data : 'group='+ request.term + "&manage=test_groups" ,
                // $_POST['group'] = request.term;
                // $_POST['manage'] = 'test_groups';
                datatype : 'jsonp',
                success : function (data) {
                    var x = jQuery.parseJSON(data) ;
                    response(x);
                }
            });  
        } , 
        minLength : 1
    } 
    
});

$('#test_groups').on('tokenfield:createtoken', function (event) {
    var existingTokens = $(this).tokenfield('getTokens');
    $.each(existingTokens, function(index, token) {
        if (token.value === event.attrs.value)
            event.preventDefault();
    });
});

$('#test_groups').on('tokenfield:createdtoken' , function (event){
    var string = $('#test_applicants').val();
    $token_value = event.attrs.value;
    $.ajax({
        type : 'POST',
        url : '../manageAjax.php' ,
        data : 'group_name='+$token_value+'&manage=addGroupMembers' 
    }).done(function(response){
        string += response;
        $('#test_applicants').tokenfield('setTokens', string);
    });
});

$('#test_groups').on('tokenfield:removedtoken', function (e) {
    $('#test_applicants').tokenfield('setTokens', []);
    $('#test_applicants').val('');
    var string = $('#test_groups').val();
    var array = string.split(", ");
    console.table(array);
    var grp_mem = "";
    if(array.length > 0){
        for(var i = 0 ; i < array.length ; i++){
            $.ajax({
                type : "POST" , 
                url : "../manageAjax.php",
                data : "group_name="+array[i]+"&manage=addGroupMembers",
            }).done(function(response){
                console.log(response);
                grp_mem += response;
                $('#test_applicants').tokenfield('setTokens', grp_mem);
            });
        }
    }
});


function btnAnnounceTestClicked(event){
    event.preventDefault();
    var test_name = $('#test_name').val();
    var test_question_set = $('#questionPaper').val();
    var test_description = $('#test_description').val();
    var test_notification = $('#test_notification').val();
    var temp = $('#test_applicants').tokenfield('getTokens');
    var temp1 = $('#test_applicants').val();
    var test_applicants = temp1;   
    $.ajax({
        type : "POST" , 
        url : "../manageAjax.php",
        data : "test_name="+test_name+"&test_question_set="+test_question_set+"&test_description="+test_description+"&test_applicants="+test_applicants+"&test_notification="+test_notification+"&manage=announce_test",
    }).done(function(response){
        console.log(response);
        alert(response);
        toastr.success("Test Announced To Selected students and groups !!");
    });  
}
/********************************************************************************************/

/************************ Test Sessions***************************************************/
$("td input[type=text]").durationPicker({
    showDays : false ,
    showSeconds : true,
});


function btnStartSessionClicked(event, test_id, btnObj) {
    event.preventDefault();    
    var string = "time_"+test_id;
    var value = $("#"+string).val();
    $.ajax({
        type : "POST" , 
        url : "../manageAjax.php",
        data : "test_id="+test_id+"&timer="+value+"&manage=test_session_start",
    }).done(function(response){
        $('#btnStartSession'+test_id).addClass('d-none');
        $('#lblSessionStarted'+test_id).removeClass('d-none');
        toastr.success("Session Started");
    });
}

function btnStopSessionClicked(event, test_id, btnObj) {
    event.preventDefault();
    $('#btnStartSession'+test_id).removeClass('d-none');
    $('#lblSessionStarted'+test_id).addClass('d-none');    
    $.ajax({
        type : "POST" , 
        url : "../manageAjax.php",
        data : "test_id="+test_id+"&manage=test_session_stop",
    });      
}