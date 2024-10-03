@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Message</a></li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <h4>{{ $message->name ?? '' }}</h4>
                            <p>
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to={{ $message->email ?? '' }}" target="_blank">
                                    {{ $message->email ?? 'Email not available' }}
                                </a>
                                ||
                                {{ $message->phone ?? 'Number not available' }}
                            </p>


                            <p class="mt-2">
                                {{ $message->message ?? '' }}
                            </p>

                            {{-- <form action="" class="mt-5">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Reply</label>
                                    <textarea class="form-control" name="description" id="tinymceExample" cols="30" rows="10"></textarea>
                                </div>
                            </form> --}}

                            <a href="{{ route('admin.message.index') }}" class="btn btn-info mt-4 rounded">Back</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
