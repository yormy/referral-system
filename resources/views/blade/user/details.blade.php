@extends('layouts.app')

@section('content')
    <div class="d-flex flex-row">
        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center blue">
                <h1 class="font-weight-light text-white">Total</h1>
                <h6 class="text-white">{{json_decode($points)->total}}</h6>
            </div>
        </div>

        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center green">
                <h1 class="font-weight-light text-white">Paid</h1>
                <h6 class="text-white">{{json_decode($points)->paid}}</h6>
            </div>
        </div>

        <div class="card flex-fill m-5">
            <div class="box p-2 rounded text-center orange">
                <h1 class="font-weight-light text-white">Unpaid</h1>
                <h6 class="text-white">{{json_decode($points)->unpaid}}</h6>
            </div>
        </div>
    </div>

    <table class="table mt-5">
        <thead>
        <tr>
            <th>Refered</th>
            <th>Date</th>
            <th>Points</th>
            <th>Action</th>
            <th>Paid</th>
        </tr>

        </thead>
        <tbody>
        @foreach (json_decode($awardedActions) as $id => $action)
            <tr>
                <td class="">@isset($action->user_id){{$action->user_id}}@endisset</td>
                <td class="">@isset($action->created_at){{$action->created_at}}@endisset</td>
                <td class="">@isset($action->points){{$action->points}}@endisset</td>
                <td class="">@isset($action->actionName){{$action->actionName}}@endisset</td>
                <td class="">@isset($action->paid){{$action->paid}}@endisset</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
