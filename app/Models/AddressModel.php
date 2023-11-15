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
        'address_line',
        'address_status',
        'user_id',
        'city',
        'zip_code'
    ];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
    protected $cleanValidationRules = false;
}