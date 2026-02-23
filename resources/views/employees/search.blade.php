@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Search Employee by National ID</h4>

    <form method="POST" action="{{ route('employee.search.submit') }}">
        @csrf

        <div class="mb-3">
            <label>National ID</label>
            <input type="text" name="national_id" class="form-control" required>
        </div>

        <button class="btn btn-primary">Search</button>
    </form>
</div>
@endsection