<?php
session_start();
$valid = false;
$bdl = 0;
?>
<html lang="fr">

<head>
	<style>
	.wrapper-new-member{
		display: inline-table;
		color: #222;
	}
	.wrapper-new-member h3{
        position: absolute;
        left: 40px;
        color: #5bc0de;
        text-shadow: none;
	}
	.wrapper-new-member #newPvForm{
		border:4px groove #999;
		padding: 1em;
		width: 70%;
		margin: 0 auto;
	}
	.wrapper-new-member #success_message{
		padding-top: 5px;
	}
/*	#wrapper-new-member #invest_price, #memberbox{
		margin: 1.5em 1em;
		box-sizing: border-box;
		border: 1px solid #999;
	}
	#wrapper-new-member #memberbox{
		padding: .1em 1em;
	}
	#wrapper-new-member #invest_price label, #memberbox label{
		margin: 5px auto;
		display: table;
		font-size: 1.3em;
		font-weight: 400;
	}
	#wrapper-new-member .membertype{
		margin-top: 1.5em;
		display: table;
	}
	#wrapper-new-member .membertype label{
		line-height: 1.25em; 
	}
	#wrapper-new-member .membertype label s{
		font-size: .7em;
		color: #888;
	}
	#wrapper-new-member .membertype label span{
		font-size: .9em;
		margin-left: .5em;
	}
	#wrapper-new-member .membertype p{
		font:.95em/1.2em lora;
	}
	#wrapper-new-member .infoform{
		margin: 2.5em 1em 1.5em;
		border: 1px solid #999;
		padding: .5em;
		box-sizing: border-box;
	}
	#wrapper-new-member .infoform > div{
		margin-bottom: 1.5em;
	}
	#wrapper-new-member .soussig{
		font:.8em/1.2em lora;
		margin:5px 1em 1.5em;
	}
	#wrapper-new-member .month-pays{
		margin: .5em 2em 2em;
	}
	#wrapper-new-member .month-pays div{
		padding: 0;
		box-sizing: border-box;
	}
	#wrapper-new-member .month-pays label{
		display: inline;
		width: 100%;
	}
	#wrapper-new-member .month-pays span{
		text-shadow: 0 0 1px black;
		font-size: .8em;
		display: inline;
	}
	#wrapper-new-member .stMonth{
		margin-bottom: 1em;
	}
	#wrapper-new-member .badgebox{
	    opacity: 0;
	}

	#wrapper-new-member .badgebox + .badge{
	    text-indent: -999999px;
		width: 27px;
	}

	#wrapper-new-member .badgebox:focus + .badge{
	    box-shadow: inset 0px 0px 5px;
	}

	#wrapper-new-member .badgebox:checked + .badge{
		text-indent: 0;
	}
	#wrapper-new-member .lsmonth{
		margin-bottom: 1em;
	}
	#wrapper-new-member .lsmonth .btn-default{
		color: #333;	
		border: none;	
		background-color: rgba(0,0,0,0);
	}
	#wrapper-new-member .lsmonth span[id$="lb"]{
		font: .9em/1em lora;		
	}
	#wrapper-new-member input[name="email"]{
		text-decoration: capital;		
	}
	#wrapper-new-member #startdate .form-control{
		font-size: 1.2em;
	}
    #wrapper-new-member .wrapper-new-member h3{
        position: absolute;
        left: 40px;
        color: #5bc0de;
        width: 20%;
        text-shadow: none;
    }
    #wrapper-new-member .wrapper-new-member{
    	width: 70%;
    	margin: 0 auto;
    }
    */
    	</style>
    
</head>

<body>
    <div class="wrapper-new-member">
		<h3>S'INSCRIRE</h3>
		<form id="newPvForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!-- ======================================  INFORMATION FORM =========================================  -->
			<div class="row">
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Pr&eacute;nom</label>
	                <input type="text" class="form-control" name="name" required="required" autocomplete="off" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"/>
	            </div>			
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Nom</label>
	                <input type="text" class="form-control" name="famil" required="required" value="<?php if(isset($_POST['famil'])){echo $_POST['famil'];} ?>"/>
	            </div>
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Adresse</label>
	                <input type="text" class="form-control" name="adress" required="required" value="<?php if(isset($_POST['adress'])){echo $_POST['adress'];} ?>"/>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	                <label class="control-label">Ville</label>
	                <input type="text" class="form-control" name="city" required="required" value="<?php if(isset($_POST['city'])){echo $_POST['city'];} ?>"/>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 selectContainer">
	                <label class="control-label">Province</label>
	                <select class="form-control" name="province" id="province">
	                    <option value="Quebec">Qu&eacute;bec</option>
	                    <option value="Ontario">Ontario</option>
	                    <option value="Nova Scotia">Nova Scotia</option>
	                    <option value="New Brunswick">New Brunswick</option>
	                    <option value="manitoba">Manitoba</option>
	                    <option value="British Columbia">British Columbia</option>
	                    <option value="Prince Edward Island">Prince Edward Island</option>
	                    <option value="Saskatchewan">Saskatchewan</option>
	                    <option value="Alberta">Alberta</option>
	                    <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
	                </select>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Code postal</label>
	                <input type="text" class="form-control" name="postal" required="required" maxlength="7" value="<?php if(isset($_POST['postal'])){echo $_POST['postal'];} ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Numéro de téléphone</label>
	                <input type="text" class="form-control" name="phone1" required="required" value="<?php if(isset($_POST['phone1'])){echo $_POST['phone1'];} ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">adresse courriel</label>
	                <input type="email" class="form-control" name="email" required="required" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
	            </div>
		            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
		                <label class="control-label">Ref#</label>
		                <input type="text" readonly="readonly" class="form-control" name="refby" value="<?php echo $_SESSION['vpcode']; ?>"/>
		            </div>
		            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		                <label class="control-label">Mot de passe (min. 5 lettres)</label>
		                <input type="text" minlength="5" class="form-control" name="passw" required="required"/>
		            </div>
		            <div id="success_message" class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>

			</div>
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


        $('form#newPvForm').submit(function(event) {
        var formData = {
            'name' : $('input[name=name]').val(),
            'famil' : $('input[name=famil]').val(),
            'adress' : $('input[name=adress]').val(),
            'city' : $('input[name=city]').val(),
            'province' : $("#province option:selected").text(),
            'postal' : $('input[name=postal]').val(),
            'email' : $('input[name=email]').val(),
            'phone' : $('input[name=phone1]').val(),
            'pw' : $('input[name=passw]').val(),
            'refby' : $('input[name=refby]').val()
		    };

            $.ajax({
                type : 'POST', 
                url : 'newuser_byadmin.php', 
                data : formData, 
                dataType : 'json', 
                encode : true
            })
                .done(function(data) {
                    if(data.success){
                        $("#success_message").css({"color": "green"});
                        $("#success_message").text("Un nouveau client enregistré avec succès!");
                        $("input[name=name]").val("");
                        $("input[name=famil]").val("");
                        $("input[name=city]").val("");
                        $("input[name=postal]").val("");
                        $("input[name=phone1]").val("");
                        $("input[name=email]").val("");
                        $("input[name=passw]").val("");
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

            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
    });



});

</script>



	
</body>
