<?php

namespace App\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name'
    ];

    public function employeesRelation(): HasMany
    {
        return $this->hasMany(Employees::class, 'department_id', 'id');
    }

    protected static function newFactory(): Factory
    {
        return DepartmentFactory::new();
    }
}
