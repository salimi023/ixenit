<?php
namespace App\Models;
use CodeIgniter\Model;

class ContactModel extends Model
{
    
    // Table data
    protected $DBGroup = 'default';

    protected $table = 'user_contact';
    protected $primaryKey = 'contact_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Columns
    protected $allowedFields = [
        'contact_id',
        'contact_data',
        'contact_type',        
        'user_id'        
    ];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
    protected $cleanValidationRules = false;
}