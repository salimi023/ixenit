/**
 * View User
 */
$(document).ready(function() {
    $(document).on("click", "button.view_user", function() {
        $("div#modal_content").html('');
        $("div#modal_title").text("Felhasználó megtekintése");

        var user_id = $(this).data("id");
        var base_url = $("span#base_url").text();
        
        $.ajax({
            url: base_url + "index.php/home/view_user",
            type: "POST",
            data: {id: user_id},
            dataType: "html",
            success: function(response) {
                if(response !== 'user_id_error') {
                    var user_data = JSON.parse(response);                    
                    
                    var html = '';
                    html += '<div class="w3-row w3-padding">';                    
                    html += '<p><strong>Név:</strong> ' + user_data.name + '</p>';
                    html += '<p><strong>Állandó lakcím:</strong></p>';
                    html += user_data.address.city + '<br />';
                    html += user_data.address.address_line + ' ' + user_data.address.zip_code + '<br />';
                    
                    if(user_data.address.temp_zip_code != 0) {
                        html += '<p><strong>Ideiglenes lakcím:</strong></p>';
                        html += user_data.address.temp_city + '<br />';
                        html += user_data.address.temp_address_line + ' ' + user_data.address.temp_zip_code + '<br />';
                    }

                    html += '<p><strong>Telefon:</strong></p>';

                    for(var x in user_data.phone) {
                        html += user_data.phone[x].contact_data + '<br />';
                    }

                    html += '<p><strong>E-mail:</strong></p>';

                    for(var x in user_data.email) {
                        html += '<a href="mailto:' + user_data.email[x].contact_data + '">' + user_data.email[x].contact_data + '</a><br />';
                    }
                    html += '</div>';

                    $("div#modal_content").html(html);
                }
            }  
        });

        $("div#user_modal").css("display", "block");
    });
});