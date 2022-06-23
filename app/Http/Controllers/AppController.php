<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    /**
     * @param EmployeeRequest $employeeRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEmployees(EmployeeRequest $employeeRequest)
    {
        /** @var Employees $employees_check */
        $employees_check = Employees::query()->exists();

        if (!$employees_check) {
            return view('404');
        }

        /** @var Employees $employees */
        $employees = Employees::query()->paginate($employeeRequest->paginate)->appends(request()->query());
        /** @var Department $departments */
        $departments = Department::query()->get();
        /** @var int $pagination */
        $pagination = $employeeRequest->paginate;

        return view('employees.main', compact('employees', 'departments', 'pagination'));
    }

    /**
     * @param DepartmentRequest $departmentRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEmployeesByDepartment(DepartmentRequest $departmentRequest)
    {
        /** @var Department $department */
        $department = Department::where(
            'department_name',
            'like',
            "%{$departmentRequest->department}%"
        )
            ->first();

        if (!$department) {
            return view('404');
        }

        /** @var Employees $employees */
        $employees = $department->employeesRelation()->paginate($departmentRequest->paginate)->appends(request()->query());
        /** @var Department $departments */
        $departments = Department::query()->get();
        /** @var int $pagination */
        $pagination = $departmentRequest->paginate;
        /** @var string $current_department */
        $current_department = $departmentRequest->department;

        return view('employees.main', compact('employees', 'departments', 'pagination', 'current_department'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getXmlView()
    {
        return view('employees.xml-parser');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function importDataFromXML(Request $request)
    {
        $request->validate([
            'xml' => 'required|file|mimes:xml',
        ]);

        /** @var  $xmlFile */
        $xmlFile = file_get_contents($request->xml);

        /** @var  $xmlObject */
        $xmlObject = simplexml_load_string($xmlFile);

        /** @var  $jsonFormatData */
        $jsonFormatData = json_encode($xmlObject);
        /** @var  $result */
        $result = json_decode($jsonFormatData, true);
        /** @var Department $department */
        $department = Department::query()->count();

        if ($department === 0) {
            return view('404');
        }

        foreach ($result['row'] as $employee) {
            /** @var  $validation */
            $validation = $this->validationDataFromXml($employee, [
                'full_name' => 'string',
                'birth_date' => 'date',
                'department_id' => 'int|min:1|max:' . $department,
                'hourly_payment' => 'bool',
                'payment_per_hour' => 'nullable|int|regex:/^\d+(\.\d{1,2})?$/|min:0|max:25',
                'worked_hours' => 'int|min:50',
                'salary' => 'regex:/^\d+(\.\d{1,2})?$/'
            ]);

            if ($validation['fails']) {
                return view('employees.xml-parser')->with(['errors' => $validation['errors']]);
            }

        }

        foreach ($result['row'] as $employee) {
            if (empty($employee['hourly_payment'])) {
                $employee['hourly_payment'] = 0;
            }
            unset($employee['deleted_at'], $employee['created_at'], $employee['updated_at']);

            Employees::create($employee);
        }

        return view('employees.xml-parser')->with(['pass' => 'Data imported!']);
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     */
    private function validationDataFromXml(array $data, array $rules): array
    {
        /** @var Validator $validator */
        $validator = Validator::make($data, $rules);

        return [
            'fails' => $validator->fails(),
            'errors' => $validator->errors(),
        ];
    }
}
