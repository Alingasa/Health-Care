@extends('home')
@section('content')
<div class="card-body">
  <h5 class="card-title fw-semibold mb-4">Create User</h5>
  <div class="card">
    <div class="card-body">
      <form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleInputFirstName" class="form-label">Role Name</label>
              <input type="text" name="role_name" class="form-control @error('role_name') is-invalid @enderror" id="exampleInputFirstName" required>
              @error('role_name')
              <p class="text-danger">{{$message}}</p>
              @enderror
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-light" href="{{route('role.index')}}">Cancel</a>
      </form>
    </div>
  </div>
</div>

<script>
  function checkRole() {
    var roleSelect = document.getElementById('exampleSelectOption');
    var specializationField = document.getElementById('specializationField');
    if (roleSelect.options[roleSelect.selectedIndex].text.toLowerCase() === 'patient') {
      specializationField.style.display = 'block';
    } else {
      specializationField.style.display = 'none';
    }
  }
</script>



@endsection