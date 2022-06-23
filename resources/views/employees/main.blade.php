@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" id="employees">
                    <div class="card-header">{{ __('Employees') }}</div>

                    <div class="card-body">
                        <div class="search">
                            <form id="form" action="{{url()->full()}}" method="get">
                                @csrf
                                <label for="paginate">Count Employees:</label>
                                <select id='paginate' name="paginate">
                                    <option value="10" {{ $pagination === '10' ? 'selected' : ''}}>10</option>
                                    <option value="25" {{ $pagination === '25' ? 'selected' : ''}}>25</option>
                                    <option value="50" {{ $pagination === '50' ? 'selected' : ''}}>50</option>
                                    <option value="100" {{ $pagination === '100' ? 'selected' : ''}}>100</option>
                                </select>
                                <label for="department">Department:</label>
                                <select id='department' name="department">
                                    <option value="any">Any</option>
                                    @foreach($departments as $department)
                                        @if (isset($current_department))
                                            <option
                                                value="{{$department->department_name}}"
                                                {{$current_department === $department->department_name ? 'selected' : ''}}>
                                                {{$department->department_name}}
                                            </option>
                                        @else
                                            <option
                                                value="{{$department->department_name}}">
                                                {{$department->department_name}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </form>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Birth Date</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Type</th>
                                    <th>Salary</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td> {{$employee->full_name}} </td>
                                        <td> {{$employee->birth_date}} </td>
                                        <td> {{$employee->departmentRelation->department_name}} </td>
                                        <td> {{$employee->position}} </td>
                                        <td> {{$employee->hourly_payment ? 'Hourly payment' : 'Wage'}} </td>
                                        <td> {{$employee->salary}} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $employees->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            let select = document.getElementById('paginate');
            let select_department = document.getElementById('department');

            select.onchange = function () {
                if (select_department.value === 'any') {
                    this.form.submit();
                }
                else {
                    this.form.submit()
                }
            };

            select_department.onchange = function () {
                if (select_department.value === 'any')
                {
                    console.log(select_department.value)
                    document.getElementById('form').setAttribute(
                        'action',
                        '{{url('/employees')}}',
                    )
                    this.form.submit()
                }
                else {
                    document.getElementById('form').setAttribute(
                        'action',
                        '/employees/' + select_department.value
                    )

                    this.form.submit()
                }
            }
        </script>
@endsection
