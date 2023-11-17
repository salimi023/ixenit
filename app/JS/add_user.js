/**
 * Add User
 */
$(document).ready(function() {
    $(document).on("click", "input#save_user", function(e) {
        e.preventDefault(); 
        var base_url = $("span#base_url").text();                                      
        
        // Name
        var first_name = $("input#first_name").val();
        var last_name = $("input#last_name").val();

        // Address
        if($("input#zip_code").val() !== '') {
            var zip_code_valid = validate_digits($("input#zip_code").val());      
            if(!zip_code_valid) {
                alert("Kérem, adjon meg egy érvényes irányítószámot!");
                $("span#validationStatus").text("Error");
            } else {
                var zip_code = $("input#zip_code").val();
            }
        }               
        
        var address = $("input#address").val();
        var city = $("input#city").val();
        
        var temp_zip_code = $("input#temp_zip_code").val();
        if(temp_zip_code !== '') {            
            var temp_zip_code_test = validate_digits($("input#temp_zip_code").val());

            if(!temp_zip_code_test) {
                alert("Kérem, adjon meg egy érvényes irányítószámot!");
                $("span#validationStatus").text("Error");
            } else {
                temp_zip_code = $("input#temp_zip_code").val();
            }
        }                       

        var temp_address = $("input#temp_address").val();
        var temp_city = $("input#temp_city").val();

        // Phone
        var phone_numbers = [];

        $("input[name='phone_number']").each(function() {
            var phone_number = $(this).val();            

            if(validate_digits(phone_number)) {
                phone_numbers.push(phone_number);
            } else {
                if(phone_number !== '') {
                    alert("Kérem, adjon meg egy érvényes telefonszámot, vagy törölje a fölösleges mezőt!");
                    $("span#validationStatus").text("Error");
                }                               
            }
        });

        // E-mail
        var emails = [];

        $("input[name='email']").each(function() {
            var email = $(this).val(); 
            
            if(email !== '') {
                emails.push(email);
            }            
        });                                                               

        if($("span#validationStatus").text() === '') {
            
            // Form data object
            var customer_data = {
                first_name: first_name,
                last_name: last_name,
                zip_code: zip_code,
                address: address,
                city: city,
                temp_zip_code: temp_zip_code,
                temp_address: temp_address,
                temp_city: temp_city,
                phone: phone_numbers,
                email: emails            
            }

            var customer_data_json = JSON.stringify(customer_data);

            // Ajax
            $.ajax({
                url: base_url + "public/index.php/home/add_user",
                type: "POST",
                data: {user: customer_data_json},
                dataType: "html",
                success: function(response) {
                    if(response === 'success') {
                        alert('Sikeres mentés.');
                        location.reload();
                    } else {
                        alert(response);
                        return;
                    }                                       
                }            
            });
        }               
    });    
});

// Validate integer datatype
function validate_digits(code) {
    return /^\d+$/.test(code);
}