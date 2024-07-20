@extends('home')
@section('content')
<div class="col-lg-12 d-flex align-items-stretch">
  <div class="card w-100">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title fw-semibold mb-0">Appointments</h5>

      </div>
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 align-middle">
          <thead class="text-dark fs-4">
            <tr>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">#</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Date</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Requests</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Doctor</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Created By</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Status</h6>
              </th>
              <th class="border-bottom-0"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($appointments as $appointment)
            <tr>
              <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</p>
              </td>
              <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$appointment->appointment_date}}</p>
              </td>
              <td class="border-bottom-0">

                <p class="mb-0 fw-normal">{{$appointment->requests}}</p>

              </td>
              <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$appointment->doctor->full_name}}</p>
              </td>
              <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$appointment->user->name}}</p>
              </td>

              <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$appointment->status}}</p>
              </td>

              <td class="border-bottom-0">
                <div class="d-flex">

                  @if($appointment->status == 'Approved')
                  <a href="#" class="btn btn-sm btn-danger me-2" data-bs-toggle="modal" data-bs-target="#rejectUserModal{{$appointment->id}}">
                    <i class="fas fa-thumbs-down"></i> Reject
                  </a>
                  @endif

                  @if($appointment->status == 'Pending')
                  <a href="#" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveUserModal{{$appointment->id}}">
                    <i class="fas fa-thumbs-up"></i> Approved
                  </a>
                  @endif
                  @include('Patient.Appointment.update')

                  <a href="" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#editUserModal{{$appointment->id}}">
                    <i class="fas fa-edit"></i>
                  </a>
                  @include('Patient.Appointment.edit')
                  <!-- <a href="#" class="btn btn-sm btn-success me-2">
                    <i class="fas fa-eye"></i>
                  </a> -->

                  <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$appointment->id}}">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  @include('Patient.Appointment.delete')
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {!! $appointments->links() !!}
      </div>
    </div>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
@endsection