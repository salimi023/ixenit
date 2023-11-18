/**
 * Delete user
 */
$(document).ready(function() {
    $(document).on("click", "button#delete_user", function() {
        var user_ids = [];
        var base_url = $("span#base_url").text();

        $("input[name='delete_user']").each(function() {
            if($(this).is(":checked")) {
                user_ids.push($(this).data("id"));
            }
        });

        if(user_ids.length > 0) {
            
            var user_ids_json = JSON.stringify(user_ids);
            
            if(confirm("Biztosan törölni akarja a kijelölt felhasználó(ka)t?")) {
                $.ajax({
                    url: base_url + "public/index.php/home/delete_user",
                    type: "POST",
                    data: {ids: user_ids_json},
                    dataType: "html",
                    success: function(response) {
                        if(response === 'Sikeres törlés.') {
                            alert(response);
                            location.reload();
                        } else {
                            alert(response);
                            return;
                        }
                    }
                });
            }
        } else {
            alert("Kérem, jelöljön ki legalább egy felhasználót!");
            return;
        }        
    }); 
});