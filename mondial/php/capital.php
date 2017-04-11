<?php
session_start();
$errMsg = ''; $formactive = false; 

?>  
<style>
    .wrapper-transactions{
        overflow: hidden;
        padding: 10px;
        font-family: Montserrat;
        padding: 2px 5px;
    }
    .wrapper-transactions form#transact_capital label{
            color: #333;
            font-size: 1.1em;
        }
    .wrapper-transactions form#transact_capital input{
            color: #006060;
            margin-bottom: .5em;
        }
    .wrapper-transactions form#transact_capital .row{
            margin-top: 25px;
        }
    .wrapper-transactions #find_user {
        top: 180px;
        left: 30px;
        color: black;
        width: 250px;
        position: absolute;
    }
    .wrapper-transactions .result{
        position: absolute; 
        background-color: #fff;       
        color: #222;
        border-top: none;
        max-height: 150px;
        overflow-y: scroll; 
        width: 100%;
        right: 15px;
    }

    .wrapper-transactions .result p{
        margin: 0;
        font-size: .9em;
        padding: 3px 4px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
        position: relative;
        text-align: left;
    }
    .wrapper-transactions .result p:hover{
        background: #f2f2f2;
    }
    .wrapper-transactions .bigger{
        font-size: 110% !important;
        text-align: center;
        text-shadow: 0 0 2px #999;
    }
    .wrapper-transactions h3{
        position: absolute;
        left: 40px;
        color: #5bc0de;
        width: 20%;
        text-shadow: none;
    }
    #success_message{
        font-size: 1.2em;
        color: green;
        margin-top: 2em;
    }
    </style>
<div class="wrapper-transactions">
<h3>Transactions de capital</h3>
                <div id="find_user">
                    <label class="control-label">Prénom et Nom</label>
                    <input type="text" class="form-control" name="name_to_find" id="name_to_find" autocomplete="off" />
                    <div class="result"></div>
                    <div id="success_message"></div>
                </div>          


        <form id="transact_capital" method="post">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="border:4px ridge #999;background-color: #fff;">
                    <label class="control-label">VP CODE</label>
                    <input type="text" class="form-control" name="code" id="code" value=""/>
                    <label class="control-label">Montant</label>    
                    <input type="number" class="form-control" name="amount" id="amount" value="0"/>
                    <label class="control-label">Date</label>
                    <input type="date" class="form-control" name="today" id="today" value="<?php echo date("Y-m-d"); ?>" <?php if($_SESSION['a']==2){echo 'readonly="readonly"';} ?>/>
                    <button type="submit" name="saveTransact" class="btn btn-info" style="margin:20px;">Sauvegarder</button> 
                </div>          
            </div>
            </div>
        </form>

</div>


<script>
$(document).ready(function(){
    $('#name_to_find').on("keyup", function(){
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
    
    $('#name_to_find').on("keyup", function(){
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
        $("#code").val(str[0]);
        $(this).parent(".result").empty();
    });


    $('form#transact_capital').submit(function(event) {
        var formData = {
            'code' : $('input[name=code]').val(),
            'amount' : $('input[name=amount]').val(),
            'today' : $('input[name=today]').val()
            };

            // process the form
            $.ajax({
                type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url : 'save_capital.php', // the url where we want to POST
                data : formData, // our data object
                dataType : 'json', // what type of data do we expect back from the server
                encode : true
            })
                // using the done promise callback
                .done(function(data) {
                    if(data.success){
                        $("#success_message").css({"color": "green"});
                        $("#success_message").text("Processus: OK");
                        $("#code").val("");
                        $("#amount").val("0");
                        $('#tabs-wrapper').delay(1500).css("visibility:hidden");
                    /*    $('#regsiter_window').slideUp(400);
                        $('#regsiter_window').css("display:none");*/
                    }
                    else{
                        $("#success_message").css({"color": "red"});
                        if(!data.errors.name){data.errors.name='';}
                        $("#success_message").text(data.errors.name);
                    }

                    // here we will handle errors and validation messages
                
                })
                .fail(function(request, status, error) {
        // show any errors
        // best to remove for production
                    $("#success_message").css({"color": "red"});
                    $("#success_message").text(request.responseText);
                })

            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
    });



});
</script>
