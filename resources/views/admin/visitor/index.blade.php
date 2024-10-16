@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Visitors</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Visitors</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Visitor Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Ip</th>
                                        <th>browser</th>
                                        <th>platform</th>
                                        <th>device</th>
                                        <th>hostname</th>
                                        <th>city</th>
                                        <th>region</th>
                                        <th>country</th>
                                        <th>loc</th>
                                        <th>org</th>
                                        <th>postal</th>
                                        <th>timezone</th>
                                        <th>date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($visitors)
                                    @foreach ($visitors as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->ip ?? ''}}</td>
                                            <td>{{ $item->browser ?? ''}}</td>
                                            <td>{{ $item->platform ?? '' }}</td>
                                            <td>{{ $item->device ?? '' }}</td>
                                            <td>{{ $item->hostname ?? ''}}</td>
                                            <td>{{ $item->city ?? '' }}</td>
                                            <td>{{ $item->region ?? ''}}</td>
                                            <td>{{ $item->country ?? '' }}</td>
                                            <td>{{ $item->loc ?? '' }}</td>
                                            <td>{{ $item->org ?? '' }}</td>
                                            <td>{{ $item->postal ?? '' }}</td>
                                            <td>{{ $item->timezone ?? '' }}</td>
                                            <td>{{ $item->created_at ?? '' }}</td>



                                        </tr>
                                    @endforeach
                                    @endisset

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
