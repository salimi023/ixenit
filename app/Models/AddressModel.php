<?php
namespace App\Models;
use CodeIgniter\Model;

class AddressModel extends Model
{
    
    // Table data
    protected $DBGroup = 'default';

    protected $table = 'user_address';
    protected $primaryKey = 'address_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Columns
    protected $allowedFields = [
        'address_id',
        'user_id',
        'address_line',                
        'city',
        'zip_code',
        'temp_address_line',                
        'temp_city',
        'temp_zip_code'
    ];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
    protected $cleanValidationRules = false;
}