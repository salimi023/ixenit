<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    // Status Messages
    const SAVE_NAME_ERROR = 'Sajnos, nem sikerült elmenteni a nevet. Kérem, próbálja meg újra!';
    const SAVE_ADDRESS_ERROR = 'Sajnos, nem sikerült elmenteni a címet. Kérem, próbálja meg újra!';
    const SAVE_PHONE_ERROR = 'Sajnos, nem sikerült elmenteni a telefonszámot. Kérem, próbálja meg újra!';
    const SAVE_EMAIL_ERROR = 'Sajnos, nem sikerült elmenteni az e-mail címet. Kérem, próbálja meg újra!';
    const ZIP_CODE_ERROR = 'Az állandó lakcím irányítószáma nem megfelelő. Kérem, ellenőrizze.';
    const TEMP_ZIP_CODE_ERROR = 'Az ideiglenes lakcím irányítószáma nem megfelelő. Kérem, ellenőrizze.';
    const SAVE_SUCCESS = 'success';
    const SAVE_ERROR = 'Sikertelen mentés.';
    const UPDATE_SUCCESS = 'Okay';
    const UPDATE_ERROR = 'Sikertelen frissítés.';
    const DELETE_CONTACT_ERROR = 'Sajnos, nem sikerült törölni a kapcsolati adatokat. Kérem, próbálja meg újra!';
    const DELETE_ADDRESS_ERROR = 'Sajnos, nem sikerült törölni a cím adatokat. Kérem, próbálja meg újra!';
    const DELETE_NAME_ERROR = 'Sajnos, nem sikerült törölni a nevet. Kérem, próbálja meg újra!';
    const DELETE_SUCCESS = 'Sikeres törlés.';
    const DELETE_ERROR = 'Sikertelen törlés.';
    
    // DB Models
    private $user_model = false;
    private $user_address_model = false;
    private $user_contact_model = false;
    
    // DB Connection
    private $db = false;

    // Constructor
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) 
    {
        parent::initController($request, $response, $logger);
        $this->user_model = new \App\Models\UserModel;
        $this->user_address_model = new \App\Models\AddressModel;
        $this->user_contact_model = new \App\Models\ContactModel;
        $this->db = \Config\Database::connect('default');
    }
    
    // Homepage
    public function index(): string
    {               
        // List of saved users        
        $users = $this->user_model->findAll();
        $users_data['users'] = [];
        
        foreach($users as $user) {
            $users_data['users'][] = $user;
        }                
        
        return view('home', $users_data);
    }

    // Add User
    public function add_user() 
    {                                                 
        if(isset($_POST)) {
            $user_data = json_decode($_POST['user'], true);

            /** Starting transaction */            
            $this->db->transStart();
            
            /** Saving user name */            
            $user_name = [
                'firstname' => $user_data['first_name'],
                'lastname' => $user_data['last_name']
            ];
            
            $save_user = $this->user_model->insert($user_name, false);                                         
            $this->errors($save_user, 'name');                      
            $saved_user_id = $this->user_model->getInsertId(); // ID of saved user

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

            $save_address = $this->user_address_model->insert($user_address, false);                        
            $this->errors($save_address, 'address');                       
            
            /** Saving Phone Number(s) */            
            foreach($user_data['phone'] as $number) {                                               
                
                if(filter_var($number, FILTER_VALIDATE_INT)) {
                    $phone_data = [
                        'user_id' => $saved_user_id,
                        'contact_data' => $number,
                        'contact_type' => 1
                    ];

                    $save_phone = $this->user_contact_model->insert($phone_data, false);                               
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

                    $save_email = $this->user_contact_model->insert($email_data, false);                                        
                    $this->errors($save_email, 'email');                    
                } else {
                    $this->errors($save_email, 'email');                                       
                }
            }
            
            /** Completing transaction */            
            $this->db->transComplete();

            /** Returning result */            
            if ($this->db->transStatus() === false) {
                $this->errors($this->db->transStatus(), 'transaction');
            } else {
                echo self::SAVE_SUCCESS;                 
            }                                                      
        }
    }    

    // Update User
    public function update_user()
    {
        if(isset($_POST)) {
            $user_data = json_decode($_POST['user'], true);

            $user_id = $user_data['user_id'];

            /** Starting transaction */            
            $this->db->transStart();

            // Name
            $name = [
                'firstname' => $user_data['first_name'],
                'lastname' => $user_data['last_name']
            ];

            $update_name = $this->user_model->whereIn('user_id', [$user_id])->set($name)->update();
            $this->errors($update_name, 'name');

            // Address

            // Validating ZIP codes
            if(filter_var($user_data['zip_code'], FILTER_VALIDATE_INT) === false) {
                $this->errors(false, 'zip_code');
            }
            
            if((!empty($user_data['temp_zip_code'])) && (filter_var($user_data['temp_zip_code'], FILTER_VALIDATE_INT) === false)) {
                $this->errors(false, 'temp_zip_code');
            }

            $address = [
                'zip_code' => $user_data['zip_code'],
                'address_line' => $user_data['address'],
                'city' => $user_data['city'],
                'temp_zip_code' => $user_data['temp_zip_code'],
                'temp_address_line' => $user_data['temp_address'],
                'temp_city' => $user_data['temp_city']
            ];

            $update_address = $this->user_address_model->whereIn('user_id', [$user_id])->set($address)->update();
            $this->errors($update_address, 'address');

            /** Contact */                      
            $this->user_contact_model->where('user_id', $user_id)->delete();

            // Phone            
            foreach($user_data['phone'] as $phone_number) {
                if(filter_var($phone_number, FILTER_VALIDATE_INT)) {
                    $phone_data = [
                        'user_id' => $user_id,
                        'contact_data' => $phone_number,
                        'contact_type' => 1
                    ];

                    $update_phone = $this->user_contact_model->insert($phone_data, false);
                    $this->errors($update_phone, 'phone');
                } else {
                    $this->errors(false, 'phone');
                }         
            }

            // Email
            foreach($user_data['email'] as $email) {
                $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

                if(filter_var($email_sanitized, FILTER_VALIDATE_EMAIL)) {
                    $email_data = [
                        'user_id' => $user_id,
                        'contact_data' => $email,
                        'contact_type' => 2
                    ];

                    $update_email = $this->user_contact_model->insert($email_data, false);
                    $this->errors($update_email, 'email');
                }
            }

            /** Completing transaction */            
            $this->db->transComplete();

            /** Returning result */            
            if ($this->db->transStatus() === false) {
                $this->errors($this->db->transStatus(), 'transaction');
            } else {
                echo self::UPDATE_SUCCESS;                 
            }                                                 
        }
    }

    // Delete User
    public function delete_user()
    {
        if(isset($_POST)) {
            $user_ids = json_decode($_POST['ids'], true);

            if(count($user_ids) > 0) {
                
                foreach($user_ids as $id) {

                    /** Starting transaction */            
                    $this->db->transStart();

                    // Removal of contact data
                    $delete_contact = $this->user_contact_model->where('user_id', $id)->delete();
                    $this->errors($delete_contact, 'delete_contact');

                    // Removal of address data
                    $delete_address = $this->user_address_model->where('user_id', $id)->delete();
                    $this->errors($delete_address, 'delete_address');

                    // Removal of name
                    $delete_name = $this->user_model->where('user_id', $id)->delete();
                    $this->errors($delete_name, 'delete_name');

                    /** Completing transaction */            
                    $this->db->transComplete();

                    /** Returning result */            
                    if ($this->db->transStatus() === false) {
                        $this->errors($this->db->transStatus(), 'delete_transaction');
                    }                                                                                  
                }
                echo self::DELETE_SUCCESS;
            } else {
                echo 'Kérem, jelöljön ki legalább egy felhasználót!';
            }
        }
    }

    // Get user data by id
    public function get_user_by_id()
    {
        if(isset($_POST)) {
            $user_id = $_POST['id'];            
            
            if(!empty($user_id)) {
                $user_data = [];

                // Name
                $name_data = $this->user_model->where('user_id', $user_id)->findAll();        
                $user_data['name'] = $name_data[0];

                // Address
                $address_data = $this->user_address_model->where('user_id', $user_id)->findAll();
                $user_data['address'] = $address_data[0];
                        
                // Phone numbers
                $phone_numbers = $this->user_contact_model->where(['user_id' => $user_id, 'contact_type' => 1])->findAll();
                $user_data['phone'] = $phone_numbers;

                // Emails
                $emails = $this->user_contact_model->where(['user_id' => $user_id, 'contact_type' => 2])->findAll();
                $user_data['email'] = $emails;                
                                                    
                echo json_encode($user_data);
            } else {
                echo 'user_id_error';
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
            'transaction' => self::SAVE_ERROR,
            'delete_name' => self::DELETE_NAME_ERROR,
            'delete_contact' => self::DELETE_CONTACT_ERROR,
            'delete_address' => self::DELETE_ADDRESS_ERROR,
            'delete_transcaction' => self::DELETE_ERROR 
        };        

        if($result === false) {
            echo $message;
            die();
        }
    }    
}
