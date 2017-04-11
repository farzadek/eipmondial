<?php
session_start();
$valid = false;
$bdl = 0;
?>
<html lang="fr">

<head>
	<style>
	.wrapper-dossier{
        overflow: hidden;
        font-family: Montserrat;
		color: #222;
	}
	.wrapper-dossier #dossierForm{
		border:4px groove #999;
		padding: 1em;
		width: 70%;
		margin: 0 auto;
	}
    .wrapper-dossier .row{
        margin-top: 15px;
    }
    .wrapper-dossier .row > div{
        margin-top: 10px;
    }
	.wrapper-dossier #success_message{
		padding-top: 5px;
	}
    .wrapper-dossier .result{
        margin-top: 0;
        box-shadow: 1px 1px 5px #888;
        border-radius: 0 0 5px 5px;
    }
    .wrapper-dossier .result p{
        font-size: .9em;
        line-height: .8em;
        cursor: pointer;
        padding: .5em 5px;
        margin: 0;
    }
    .wrapper-dossier .result p:hover{
        color: white;
        background-color: #5bc0de;
    }
    	</style>
    
</head>

<body>
    <div class="wrapper-dossier">
		<form id="dossierForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Client</label>
                    <input type="text" class="form-control" name="clienta" id="clienta" required="required" autocomplete="off" />
                    <div class="result"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Score de crédit</label>
                    <input type="number" class="form-control" name="score" id="score" value="0" min="0" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Montant du prêt alloué</label>
                    <input type="text" class="form-control" name="montantalloe" id="montantalloe" min="0" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Paiement par mois réel</label>
                    <input type="text" class="form-control" name="dettereal" id="dettereal" min="0" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de prélévement</label>
                    <input type="number" class="form-control" name="dayforpay" id="dayforpay" value="1" min="1" max="31" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Banque</label>
                    <input type="text" class="form-control" name="bank1" id="bank1"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Numéro de compte</label>
                    <input type="text" class="form-control" name="accountno" id="accountno"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de bébut</label>
                    <input type="date" class="form-control" name="stdate" id="stdate"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de fin</label>
                    <input type="date" class="form-control" name="enddate" id="enddate"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Nombre de mois total</label>
                    <input type="number" class="form-control" name="totalmonth" id="totalmonth" value="0" readonly="readonly" />
                </div>
            </div>
            <div id="success_message">h</div>


		    <button type="submit" name="savedossier" class="btn btn-info" style="margin:20px 0;">Sauvegarder</button>     

		</form>


<script>

$(document).ready(function() {

    /*
    $('#dossierForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            client: {
                row: '.col-lg-4 .col-md-4 .col-sm-4 .col-xs-12',
                validators: {
                    notEmpty: {
                        message: 'VP Code est requise!'
                    },
                    stringLength: {
                        max: 9,
                        message: 'format VP20xxxxx'
                    }
                }
            },
            score: {
                row: '.col-lg-4 .col-md-4 .col-sm-4 .col-xs-12',
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
    });   */
	function monthDiff(d1, d2) {
	    var months;
	    months = (d2.getFullYear() - d1.getFullYear()) * 12;
	    months -= d1.getMonth() + 1;
	    months += d2.getMonth();
	    return months <= 0 ? 0 : months;
	}
    $('#clienta').on("keyup", function(){
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
    $('#clienta').on("blur", function(){
        var term = $(this).val();
        if(term.length){
            $.get("livesearch2.php", {query: term}).done(function(data){
                info = data.split("|");
                $("input[name=score]").val(info[0]);
                $("input[name=montantalloe]").val(info[1]);
                $("input[name=dettereal]").val(info[2]);
                $("input[name=dayforpay]").val(info[3]);
                $("input[name=bank1]").val(info[4]);
                $("input[name=accountno]").val(info[5]); 
                q = info[6][0]+info[6][1]+info[6][2]+info[6][3]+info[6][4]+info[6][5]+info[6][6]+info[6][7]+info[6][8]+info[6][9];
                $("input[name=stdate]").val(q); 
                q = info[7][0]+info[7][1]+info[7][2]+info[7][3]+info[7][4]+info[7][5]+info[7][6]+info[7][7]+info[7][8]+info[7][9];
                $("input[name=enddate]").val(q); 
            });
        } else{
        }
    });
    $(document).on("click", ".result p", function(){
        var str = $(this).text();
        var str = str.split(" ");
        $("#clienta").val(str[0]);
        $(this).parent(".result").empty();
    });

    $('#stdate').on("change", function(){
        d1 = new Date($( "#stdate" ).val());
        d2 = new Date($( "#enddate").val());
        $('#totalmonth').val(monthDiff(d1, d2));
    });
    $('#enddate').on("change", function(){
		d1 = new Date($( "#stdate" ).val());
		d2 = new Date($( "#enddate").val());
        $('#totalmonth').val(monthDiff(d1, d2));
    });

    $('form#dossierForm').submit(function(event) {
        var formData = {
            'code' : $('input[name=clienta]').val(),
            'score' : $('input[name=score]').val(),
            'montantalloe' : $('input[name=montantalloe]').val(),
            'dettereal' : $('input[name=dettereal]').val(),
            'dayforpay' : $('input[name=dayforpay]').val(),
            'bank1' : $('input[name=bank1]').val(),
            'accountno' : $('input[name=accountno]').val(),
            'stdate' : $('input[name=stdate]').val(),
            'enddate' : $('input[name=enddate]').val(),
            'totalmonth' : $('input[name=totalmonth]').val()
		    };

            $.ajax({
                type : 'POST', 
                url : 'dossier_byadmin.php', 
                data : formData, 
                dataType : 'json', 
                encode : true
            })
                .done(function(data) {
                    if(data.success){
                        $("#success_message").css({"color": "green"});
                        $("#success_message").text("Dossier de client est sauvgardé!");
                        $("input[name=code]").val("");
                        $("input[name=score]").val("");
                        $("input[name=montantalloe]").val("");
                        $("input[name=dettereal]").val("");
                        $("input[name=dayforpay]").val("");
                        $("input[name=bank1]").val("");
                        $("input[name=accountno]").val("");
                    }
                    else{
                        $("#success_message").css({"color": "red"});
                        $("#success_message").text(data.errors.name);
                        if(!data.errors.name){data.errors.name='';}
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
