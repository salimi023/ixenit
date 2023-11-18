/**
 * Update User
 */
$(document).ready(function() {
    $(document).on("click", "button.update_user", function(e) {
        var user_id = $(e.target).data("id");
        var base_url = $("span#base_url").text();
        $("div#modal_title").text("Felhasználó adatainak frissítése");

        $.ajax({
            url: base_url + "public/index.php/home/get_update_user",
            type: "POST",
            data: {id: user_id},
            dataType: "html",
            success: function(response) {                
                var user_data = JSON.parse(response);

                if(response !== 'user_id_error') {
                    
                    /** Filling out user's form modal */ 
                    
                    // Name
                    $("input#last_name").val(user_data.name.lastname);
                    $("input#first_name").val(user_data.name.firstname);
                    
                    // Address
                    $("input#zip_code").val(user_data.address.zip_code);
                    $("input#address").val(user_data.address.address_line);
                    $("input#city").val(user_data.address.city);

                    if(user_data.address.temp_zip_code != 0) {
                        $("input#temp_zip_code").val(user_data.address.temp_zip_code);
                        $("input#temp_address").val(user_data.address.temp_address_line);
                        $("input#temp_city").val(user_data.address.temp_city);
                    }

                    // Phone
                    $("input[name='phone_number']").val(user_data.phone[0].contact_data).prop({id: user_data.phone[0].contact_id });

                    if(user_data.phone.length > 1) {
                        var extra_phone_numbers = user_data.phone.length - 1;
                        
                        for(var i = 1; i <= extra_phone_numbers; i++) {
                            var html = '';
                            html += '<div class="w3-row w3-margin-top number_container">';
                            html += '<div class="w3-twothird">';
                            html += '<input class="w3-input w3-border valid" id="' + user_data.phone[i].contact_id + '" name="phone_number" type="text" maxlength="11" value="' + user_data.phone[i].contact_data + '" />';
                            html += '<span class="alert"></span>';
                            html += '</div>';
                            html += '<div class="w3-rest"><button class="w3-btn w3-red w3-round w3-margin-left delete_phone_number">Törlés</button></div>';
                            html += '</div>';

                            $("div#phone_numbers").append(html);
                        }
                    }
                    
                    // Email
                    $("input[name='email']").val(user_data.email[0].contact_data).prop({id: user_data.email[0].contact_id });

                    if(user_data.email.length > 1) {
                        var extra_emails = user_data.email.length - 1;
                        
                        for(var i = 1; i <= extra_emails; i++) {
                            var html = '';
                            html += '<div class="w3-row w3-margin-top email_container">';
                            html += '<div class="w3-twothird">';
                            html += '<input class="w3-input w3-border valid" id="' + user_data.email[i].contact_id + '" name="email" type="email" value="' + user_data.email[i].contact_data + '" />';
                            html += '<span class="alert"></span>';
                            html += '</div>';
                            html += '<div class="w3-rest"><button class="w3-btn w3-red w3-round w3-margin-left delete_email">Törlés</button></div>';
                            html += '</div>';

                            $("div#emails").append(html); 
                        }
                    }

                    // User ID
                    $("span#update_user_id").text(user_id);
                    
                    // Update button
                    $("input.send").prop({name: 'update_user', id: 'update_user', value: 'Frissítés'});

                    $("div#user_modal").css("display", "block");
                }
            }
        });
    });
});