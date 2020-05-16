@extends('layouts.main')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit employee</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Employee</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">


                <form role="form" action="{{ route('employees.update', $employee->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    {{ method_field('put') }}

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input value="{{ $employee->name }}" type="text" name="name" class="form-control"
                            class="@error('name') is-invalid @enderror">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ $employee->email }}" type="text" name="email" class="form-control">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <select name="sex" class="form-control">
                            <option value="">Please Select...</option>
                            <option {{ $employee->sex === 'Male' ? 'selected' : '' }} value="Male">Male</option>
                            <option {{ $employee->sex === 'Female' ? 'selected' : '' }} value="Female">Female</option>
                        </select>
                        @error(' sex') <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="place_of_birth">Place of Birth</label>
                        <input value="{{ $employee->place_of_birth }}" type="text" name="place_of_birth"
                            class="form-control">
                        @error('place_of_birth')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input value="{{ $employee->date_of_birth }}" type="date" name="date_of_birth"
                            class="form-control">
                        @error('date_of_birth')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" rows="5">{{ $employee->address }}</textarea>
                        @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input value="{{ $employee->phone }}" type="text" name="phone" class="form-control">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <select name="position" class="form-control">
                            <option value="">Please Select...</option>
                            @foreach ($position as $p)
                            <option {{ $p->id == $employee->position_id ? 'selected' : '' }} value="{{ $p->id }}">
                                {{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('position')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="education">Education</label>
                        <select name="education" class="form-control">
                            <option value="">Please Select...</option>
                            @foreach ($education as $p)
                            <option {{ $p->id == $employee->education_id ? 'selected' : '' }} value="{{ $p->id }}">
                                {{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('education')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                        <div class="col-sm-10">
                            <input type="file" name="photo" class="form-control" id="photo">
                            <div style="display: none" id="image-alert" class="alert alert-danger mt-1" role="alert">
                                File is not a picture</div>
                        </div>
                        <span class="input-icon icon-right"></span>

                        @if ($errors->has('photo'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('photo') }}</strong>
                        </span>
                        @endif
                        @error('photo')

                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Old Photo</label>
                            <div class="col-sm-10">
                                <img style="widht:200px; height: 300px;" src="{{ asset($employee->photo) }}" alt="">
                            </div>
                        </div>
                    </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            </form>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

</div> -->
@endsection

@push('scripts')
<script>
    var extList = [
        'jpg',
        'jpeg',
        'gif',
        'png',
    ]

    $('#photo').change(function (event) {
        var imgExt = $(this).val().split('.').pop().toLowerCase();

        if (extList.indexOf(imgExt) != -1) {
            $('#image-alert').hide();
        } else {
            $('#image-alert').show();
        }

    });

</script>
@endpush
