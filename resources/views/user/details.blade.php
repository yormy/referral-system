@extends('layouts.app')

@section('content')
    user details

    <div class="d-flex flex-row">
        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center blue">
                <h1 class="font-weight-light text-white">total</h1>
                <h6 class="text-white">value</h6>
            </div>
        </div>

        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center green">
                <h1 class="font-weight-light text-white">paid</h1>
                <h6 class="text-white">value</h6>
            </div>
        </div>

        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center orange">
                <h1 class="font-weight-light text-white">unpaid</h1>
                <h6 class="text-white">value</h6>
            </div>
        </div>

    </div>

    Filter:<br>
    [?] Only paid <br>
    [?] Only unpaid <br>
?paginated <br>
    <table class="table mt-5">
        <thead>
        <tr>
            <th>Reffered</th>
            <th>Date</th>
            <th>Points</th>
            <th>Action</th>
            <th>Paid</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="">cccc</td>
        </tr>
        </tbody>
    </table>
@endsection
