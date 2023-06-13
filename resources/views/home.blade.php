@extends('layouts.app')

@section('content')
    <style>
        .error {
            color: red;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employee List</div>

                    <div class="card-body">

                        <!-- Button trigger Add Employee modal -->
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#AddEmployee">
                            Add Employee
                        </button>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $employee)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->mobile }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary edit"
                                                data-bs-toggle="modal" data-bs-target="#EditEmployee"
                                                data-id="{{ $employee->id }}">
                                                Edit
                                            </button>
                                            <a href="#" class="btn btn-outline-danger" id="delete">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                        <!--Add Employee Modal -->
                        <div class="modal fade" id="AddEmployee" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form" action="{{ route('employee.add') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Employee Name</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                                <span id="nameErrorMessage"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">Employee Contact Number</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile">
                                                <span id="nameErrorMessage1"></span>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Employee</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <!--Edit Employee Modal -->
                        <div class="modal fade" id="EditEmployee" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="EditForm">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Employee Name</label>
                                                <input type="text" class="form-control" id="name1" name="name">
                                                <span id="nameErrorMessage"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">Employee Contact Number</label>
                                                <input type="text" class="form-control" id="mobile1" name="mobile">
                                                <span id="nameErrorMessage1"></span>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
{{-- Sweet Alert CDN link --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $('#delete').on('click', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        console.log(link);
        Swal.fire({
            title: 'Are you sure ?',
            text: "You won't be able to revert this !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
            }
        })
    });
</script>



{{-- Jquery Validation --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    $('#form').validate({
        rules: {
            name: {
                required: true,
                minlength: '4'
            },
            mobile: {
                required: true,
                phoneUS: true,
                number: true
            }

        },
        messages: {
            name: {
                required: 'Name Is Required!',
            },
            mobile: {
                required: "Please enter your phone number",
                // phoneUS: "Please enter a valid phone number: (e.g. 19999999999 or 9999999999)"
            }
        },
        submitHandler: function() {
            form.submit();
        }
    });
</script>


<script>
    $(document).ready(function() {
        $('.edit').on('click', function(event) {
            var id = $(this).data('id');

            var url = "{{ route('employee.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#name1').val(data.data.name);
                    $('#mobile1').val(data.data.mobile);
                    console.log(data);
                }
            });
        });

        //Add Form
        $('#form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#AddEmployee').modal('hide');
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    if (errors) {
                        $('#nameErrorMessage').text(errors.name[0]);
                        $('#nameErrorMessage1').text(errors.mobile[0]);
                        console.log(errors);
                    }
                }
            });
        });

        //Edit Form
        $('#EditForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = $(this).data('id');
            var url = "{{ route('employee.update', ['id' => ':id']) }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                method: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    $('#EditForm').modal('hide');
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    if (errors) {
                        $('#nameErrorMessage').text(errors.name[0]);
                        $('#nameErrorMessage1').text(errors.mobile[0]);
                        console.log(errors);
                    }
                }
            });
        });
    });
</script>
