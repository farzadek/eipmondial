<?php
session_start();
$valid = false;
$bdl = 0;
?>
<html lang="fr">

<head>
	<style>
	.wrapper-loan{
        overflow: hidden;
        font-family: Montserrat;
		color: #222;
	}
	.wrapper-loan #loanForm{
		border:4px groove #999;
		padding: 1em;
		width: 60%;
		margin: 0 auto;
	}
    .wrapper-loan .row{
        margin-top: 15px;
    }
	.wrapper-loan #success_message{
		padding-top: 5px;
        font-size: 1em;
	}
    .wrapper-loan .result{
        margin-top: 0;
        box-shadow: 1px 1px 5px #888;
        border-radius: 0 0 5px 5px;
    }
    .wrapper-loan .result p{
        font-size: .9em;
        line-height: .8em;
        cursor: pointer;
        padding: .5em 5px;
        margin: 0;
    }
    .wrapper-loan .result p:hover{
        color: white;
        background-color: #5bc0de;
    }
    	</style>
    
</head>

<body>
    <div class="wrapper-loan">
		<form id="loanForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!-- ======================================  INFORMATION FORM =========================================  -->
			<h3>Investissement</h3>
            <!--
            <div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="requesttype" value="Investor" id="req1"/> Investissement
					</label>	
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline ">
						<input type="radio" name="requesttype" value="Loan" id="req2"> Prêt
					</label> 
				</div>
            </div>
            -->
            <!-- ======================================  INVEST PRICE =========================================  -->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">VP.Code</label>
                    <input type="text" class="form-control" name="client" id="client" required="required" autocomplete="off" />
                    <div class="result"></div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                        <div class="form-group">
                            <label for="investAmount">Montant</label>
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input type="text" min="0" max="1000000" value="0" class="form-control" id="investAmount" name="investAmount" placeholder="0.00">
                            </div>
                        </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de début</label>
                    <input type="date" class="form-control" name="stdate" id="stdate" required="required" value="<?php echo date("Y-m-d");?>"/>
                    <div class="result"></div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de fin</label>
                    <input type="date" class="form-control" name="findate" id="findate" required="required" value="<?php echo date("Y-m-d");?>"/>
                    <div class="result"></div>
                </div>
            </div>
            <div id="success_message"></div>


		    <button type="submit" name="membersuivant1" class="btn btn-info" style="margin:20px 0;">Sauvegarder</button>     

		</form>


<script>

$(document).ready(function() {

    /*
    $('#newPvForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                row: '.col-xs-8',
                validators: {
                    notEmpty: {
                        message: 'The Name is required'
                    },
                    stringLength: {
                        max: 50,
                        message: 'The title must be less than 50 characters long'
                    }
                }
            },
            genre: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The genre is required'
                    }
                }
            },
            director: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The director name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The director name must be less than 80 characters long'
                    }
                }
            },
            writer: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The writer name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The writer name must be less than 80 characters long'
                    }
                }
            },
            producer: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The producer name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The producer name must be less than 80 characters long'
                    }
                }
            },
            website: {
                row: '.col-xs-6',
                validators: {
                    notEmpty: {
                        message: 'The website address is required'
                    },
                    uri: {
                        message: 'The website address is not valid'
                    }
                }
            },
            trailer: {
                row: '.col-xs-6',
                validators: {
                    notEmpty: {
                        message: 'The trailer link is required'
                    },
                    uri: {
                        message: 'The trailer link is not valid'
                    }
                }
            },
            review: {
                // The group will be set as default (.form-group)
                validators: {
                    stringLength: {
                        max: 500,
                        message: 'The review must be less than 500 characters long'
                    }
                }
            },
            rating: {
                // The group will be set as default (.form-group)
                validators: {
                    notEmpty: {
                        message: 'The rating is required'
                    }
                }
            }
        }
    });*/

    $('#client').on("keyup", function(){
        var term = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(term.length){
            $.get("livesearch.php", {query: term}).done(function(data){
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    $(document).on("click", ".result p", function(){
        var str = $(this).text();
        var str = str.split(" ");
        $("#client").val(str[0]);
        $(this).parent(".result").empty();
    });
/*
    $('#client').on("blur", function(){
        var formData = {
            'client' : $('input[name=client]').val()
            };

            $.ajax({
                type : 'POST', 
                url : 'pull_data.php', 
                data : formData, 
                dataType : 'json', 
                encode : true
            })
                .done(function(data) {
                    if(data.success){
                        $("input[name=client]").val("");
                        $("input[name=investAmount]").val("");
                    }
                    else{
                        $("#success_message").css({"color": "red"});
                        if(!data.errors.name){data.errors.name='';}
                        $("#success_message").text(data.errors.name);
                    }                
                })
                .fail(function(request, status, error) {
                    $("#success_message").css({"color": "red"});
                    $("#success_message").text(request.responseText);
                })
                event.preventDefault();

    });
*/
        $('form#loanForm').submit(function(event) {
        var formData = {
            'client' : $('input[name=client]').val(),
            'amount' : $('input[name=investAmount]').val(),
            'stdate' : $('input[name=stdate]').val(),
            'findate' : $('input[name=findate]').val()
		    };

            $.ajax({
                type : 'POST', 
                url : 'newloan_byadmin.php', 
                data : formData, 
                dataType : 'json', 
                encode : true
            })
                .done(function(data) {
                    if(data.success){
                        $("#success_message").css({"color": "green"});
                        $("#success_message").text("Un Investissment/Prêt à enregistré pour cet client!");
                        $("input[name=client]").val("");
                        $("input[name=investAmount]").val("");
                        $('form#loanForm').reset();
                    }
                    else{
                        $("#success_message").css({"color": "red"});
                        if(!data.errors.name){data.errors.name='';}
                        $("#success_message").text(data.errors.name);
                    }                
                })
                .fail(function(request, status, error) {
                    $("#success_message").css({"color": "red"});
                    $("#success_message").text(request.responseText);
                })
                event.preventDefault();
    });



});

</script>



	
</body>
