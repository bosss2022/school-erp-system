@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Guardian</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guardians.update', $guardian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $guardian->first_name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $guardian->last_name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $guardian->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $guardian->phone) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $guardian->address) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Relation</label>
                        <input type="text" name="relation" class="form-control" value="{{ old('relation', $guardian->relation) }}">
                    </div>
                </div>

     <div class="col-md-6 mb-3">
    <label for="student_id" class="form-label">Assign Student</label>
    <select name="student_id" id="student_id" class="form-select">
        <option value="">-- Select Student --</option>
        @foreach($students as $id => $label)
            <option value="{{ $id }}" {{ old('student_id') == $id ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<!-- Initialize Select2 -->
@push('scripts')
<script>
    $(document).ready(function() {
        $('#student_id').select2({
            placeholder: "Search and select a student",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush



                <div class="text-end">
                    <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Guardian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
