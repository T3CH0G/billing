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
            $(wrapper).append('<div class="row" id="divs"><div class="col-md-3"><label for="item" class="control-label">Item:</label></div><div class="col-md-3"><label for="description" class="control-label">Description:</label></div><div class="col-md-2"><label for="cost" class="control-label">Cost:</label></div><div class="col-md-2"><label for="quantity" class="control-label">Quantity:</label></div><div class="col-md-2"></div></div>');
            $(wrapper).append('<div class="row" id="divs"><div class="col-md-3"><input type="text" name="item[]"/></div><div class="col-md-3"><input type="text" name="description[]"/></div><div class="col-md-2"><input type="text" name="cost[]"/></div><div class="col-md-2"><input type="text" name="quantity[]"/></div><div class="col-md-2"><a href="#" id="rm" class="remove_field">Remove</a></div></div>');
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $("#divs").remove(); x--;
        $("#divs").remove(); x--;
    })
});