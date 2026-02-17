@extends('layouts.admin')

@section('content')
    <div class="container">

        <h3 class="mb-3">Edit Religion</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('religion.update', $religion->id) }}" method="POST">
                    @csrf

                    @include('masters.religion.form')


                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('religion.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>


                </form>

            </div>
        </div>

    </div>
@endsection