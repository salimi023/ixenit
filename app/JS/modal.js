$(document).ready(function() {
    // Open modal
    $("button#add_user").on("click", function() {
        $("div#modal_title").text("Új Felhasználó");
        $("div#user_modal").css("display", "block");
    });

    // Add new phone number
    $(document).on("click", "button#add_phone_number", function(e) {
        e.preventDefault();
        var html = '';
        html += '<div class="w3-row w3-margin-top number_container">';
        html += '<div class="w3-twothird">';
        html += '<input class="w3-input w3-border valid" id="" name="phone_number" type="text" maxlength="11" />';
        html += '<span class="alert"></span>';
        html += '</div>';
        html += '<div class="w3-rest"><button class="w3-btn w3-red w3-round w3-margin-left delete_phone_number">Törlés</button></div>';
        html += '</div>';

        $("div#phone_numbers").append(html);

        $("input[name='phone_number']").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '');            
        });
    });

    // Remove phone number
    $(document).on("click", "button.delete_phone_number", function(e) {
        e.preventDefault();        
        $(e.target).closest("div.number_container").remove();
        $("span#validationStatus").text('');         
    });

    // Add new email
    $(document).on("click", "button#add_email", function(e) {
        e.preventDefault();
        var html = '';
        html += '<div class="w3-row w3-margin-top email_container">';
        html += '<div class="w3-twothird">';
        html += '<input class="w3-input w3-border valid" id="" name="email" type="email" />';
        html += '<span class="alert"></span>';
        html += '</div>';
        html += '<div class="w3-rest"><button class="w3-btn w3-red w3-round w3-margin-left delete_email">Törlés</button></div>';
        html += '</div>';

        $("div#emails").append(html);        
    });

    // Remove email
    $(document).on("click", "button.delete_email", function(e) {
        e.preventDefault();        
        $(e.target).closest("div.email_container").remove();
        $("span#validationStatus").text('');        
    });

    // Validate temporary address data
    $(document).on("change", "input.temp", function() {
        if($(this).val() !== '') {
            $("input.temp").each(function() {
                $(this).addClass('valid'); 
                $("span.temp_title").removeClass('w3-hide');               
            }); 
        } else {
            $("input.temp").each(function() {
                $(this).val('');
                $(this).removeClass('valid');
                $(this).siblings('span.alert').text('');
                $("span.temp_title").addClass('w3-hide');                 
            }); 
        }
    });

    // Close modal
    $("span#close_modal").on("click", function() {
        $("div#user_modal").css("display", "none");
        location.reload();
    });
});