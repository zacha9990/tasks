@extends('layouts.main')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employees</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
          
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Employees List</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">

        @if(Auth::guard('admin')->check())
        <a href="{{ route('employees.create') }}" class="btn btn-outline-dark mb-2"> <i class="mdi mdi-plus-box"></i> Add Employee</a>
        @endif  
        <div   class = "col-lg-12">
            <table class = "table table-bordered" id = "users-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>                
                        <th>Photo</th>
                        <th>Sex</th>
                        <th>Place of Birth</th>         
                        <th>Date of Birth</th>   
                        <th>Address</th>   
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Education</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
@endsection

@push('scripts')
@if(Auth::guard('admin')->check())
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('employee.lists') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'photo_x', name: 'photo_x', orderable: false, searchable: false },    
            { data: 'sex', name: 'sex' },    
            { data: 'place_of_birth', name: 'place_of_birth' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },            
            { data: 'position_id', name: 'position_id' },
            { data: 'education_id', name: 'education_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@else
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('employee.lists') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'photo_x', name: 'photo_x', orderable: false, searchable: false },    
            { data: 'sex', name: 'sex' },    
            { data: 'place_of_birth', name: 'place_of_birth' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },            
            { data: 'position_id', name: 'position_id' },
            { data: 'education_id', name: 'education_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endif
@endpush