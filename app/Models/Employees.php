<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\EmployeesFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * class Employees
 *
 * @package App\Models
 *
 * @property string $full_name
 * @property Carbon $birth_date
 * @property int $department_id
 * @property string $position
 * @property boolean $hourly_payment
 * @property double $payment_per_hour
 * @property double $worked_hours
 * @property double $salary
 */
class Employees extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'full_name',
        'birth_date',
        'department_id',
        'position',
        'hourly_payment',
        'payment_per_hour',
        'worked_hours',
        'salary'
    ];

    /**
     * @return BelongsTo
     */
    public function departmentRelation(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return EmployeesFactory::new();
    }
}
