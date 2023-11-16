<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    
    // Table data
    protected $DBGroup = 'default';

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Columns
    protected $allowedFields = [
        'user_id',
        'firstname',
        'lastname'
    ];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
    protected $cleanValidationRules = false;
}