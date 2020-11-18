@extends('layouts.app')

@section('content')
    <h1> Admin overview</h1>

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

    <table class="table mt-5">
        <thead>
        <tr>
            <th>Affiliate</th>
            <th>total points</th>
            <th>paid</th>
            <th>unpaid</th>
            <th>data last action</th>
            <th>action</th>
        </tr>
        </thead>
        <tbody>

            @foreach (json_decode($referrers) as $id => $referrer)
            <tr>
                <td class="">{{$id}}</td>
                <td class="">@isset($referrer->total){{$referrer->total}}@endisset</td>
                <td class="">@isset($referrer->paid){{$referrer->paid}}@endisset</td>
                <td class="">@isset($referrer->unpaid){{$referrer->unpaid}}@endisset</td>
                <td class="">@isset($referrer->created_at){{$referrer->created_at}}@endisset</td>
            <td class="">[open]</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
