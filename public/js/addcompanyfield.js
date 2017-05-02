$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $("#rm").remove(); 
            $(wrapper).append('<div class="row" id="divs"><div class="col-md-3"><label for="custom_payment_term" class="control-label">Custom Payment Term:</label></div><div class="col-md-3"><label for="invoice_1" class="control-label">Invoice 1 Percentage:</label></div><div class="col-md-3"><label for="invoice_2" class="control-label">Invoice 2 percentage:</label></div><div class="col-md-3"></div></div>');
            $(wrapper).append('<div class="row" id="divs"><div class="col-md-3"><input type="text" name="custom_payment_term[]"/></div><div class="col-md-3"><input type="text" name="invoice_1[]"/></div><div class="col-md-3"><input type="text" name="invoice_2[]"/></div><div class="col-md-3"><a href="#" id="rm" class="remove_field">Remove</a></div></div>');
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $("#divs").remove(); x--;
        $("#divs").remove(); x--;
    })
});