<?php

namespace App\Controllers;

class Home extends BaseController
{
    const SAVE_NAME_ERROR = 'Sajnos nem sikerült elmenteni a nevet. Kérem, próbálja meg újra!';
    const SAVE_ADDRESS_ERROR = 'Sajnos nem sikerült elmenteni a címet. Kérem, próbálja meg újra!';
    const SAVE_PHONE_ERROR = 'Sajnos nem sikerült elmenteni a telefonszámot. Kérem, próbálja meg újra!';
    const SAVE_EMAIL_ERROR = 'Sajnos nem sikerült elmenteni az e-mail címet. Kérem, próbálja meg újra!';
    const ZIP_CODE_ERROR = 'Az állandó lakcím irányítószáma nem megfelelő. Kérem, ellenőrizze.';
    const TEMP_ZIP_CODE_ERROR = 'Az ideiglenes lakcím irányítószáma nem megfelelő. Kérem, ellenőrizze.';
    const SAVE_SUCCESS = 'Sikeres mentés.';
    const SAVE_ERROR = 'Sikertelen mentés.';          
    
    // Homepage
    public function index(): string
    {
        return view('home');
    }

    // Add User
    public function add_user() 
    {               
        /** DB Connection */
        $db = \Config\Database::connect('default');
        
        /** DB Models */        
        $user_model = new \App\Models\UserModel;
        $address_model = new \App\Models\AddressModel;
        $contact_model = new \App\Models\ContactModel;        
        
        if(isset($_POST)) {
            $user_data = json_decode($_POST['user'], true);

            /** Starting transaction */            
            $db->transStart();
            
            /** Saving user name */            
            $user_name = [
                'firstname' => $user_data['first_name'],
                'lastname' => $user_data['last_name']
            ];

            $save_user = $user_model->insert($user_name, false);                                         
            $this->errors($save_user, 'name');                      
            $saved_user_id = $user_model->getInsertId(); // ID of saved user

            /** Saving User Address(es) */            
            
            // Validating ZIP codes
            if(filter_var($user_data['zip_code'], FILTER_VALIDATE_INT) === false) {
                $this->errors(false, 'zip_code');
            }
            
            if((!empty($user_data['temp_zip_code'])) && (filter_var($user_data['temp_zip_code'], FILTER_VALIDATE_INT) === false)) {
                $this->errors(false, 'temp_zip_code');
            }             

            $user_address = [
                'user_id' => $saved_user_id,
                'zip_code' => $user_data['zip_code'],
                'address_line' => $user_data['address'],
                'city' => $user_data['city'],
                'temp_zip_code' => $user_data['temp_zip_code'],
                'temp_address_line' => $user_data['temp_address'],
                'temp_city' => $user_data['temp_city']                
            ];

            $save_address = $address_model->insert($user_address, false);                        
            $this->errors($save_address, 'address');                       
            
            /** Saving Phone Number(s) */            
            foreach($user_data['phone'] as $number) {                                               
                
                if(filter_var($number, FILTER_VALIDATE_INT)) {
                    $phone_data = [
                        'user_id' => $saved_user_id,
                        'contact_data' => $number,
                        'contact_type' => 1
                    ];

                    $save_phone = $contact_model->insert($phone_data, false);                               
                    $this->errors($save_phone, 'phone');
                } else {
                    $this->errors(false, 'phone');
                }                               
            }

            /** Saving Email Account(s) */            
            foreach($user_data['email'] as $email) {

                $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
                
                if(filter_var($email_sanitized, FILTER_VALIDATE_EMAIL)) {
                    $email_data = [
                        'user_id' => $saved_user_id,
                        'contact_data' => $email,
                        'contact_type' => 2
                    ];

                    $save_email = $contact_model->insert($email_data, false);                                        
                    $this->errors($save_email, 'email');                    
                } else {
                    $this->errors($save_email, 'email');                                       
                }
            }
            
            /** Completing transaction */            
            $db->transComplete();

            /** Returning result */            
            if ($db->transStatus() === false) {
                $this->errors($db->transStatus(), 'transaction');
            } else {
                echo self::SAVE_SUCCESS;                 
            }                                                      
        }
    }

    // Error handling
    private function errors($result, $keyword) 
    {        
        $message = match($keyword) {
            'name' => self::SAVE_NAME_ERROR,
            'zip_code' => self::ZIP_CODE_ERROR,
            'temp_zip_code' => self::TEMP_ZIP_CODE_ERROR,
            'address' => self::SAVE_ADDRESS_ERROR,
            'phone' => self::SAVE_PHONE_ERROR,
            'email' => self::SAVE_EMAIL_ERROR,
            'transaction' => self::SAVE_ERROR 
        };        

        if($result === false) {
            echo $message;
            die();
        }
    }
}
