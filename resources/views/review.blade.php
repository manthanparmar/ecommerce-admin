@extends('index')

@section('content')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Reviews List</h4>
        <!-- <p class="card-description"> Add class <code>.table</code> -->
        </p>
        <div class="table-responsive">
        <ul class="list-group">
            @foreach($reviewData as $review)
                <li class="list-group-item">
                    <strong>User:</strong> {{ $review->username ?? 'Anonymous' }} <br>
                    <strong>Product:</strong> {{ $review->product_name ?? 'No Product' }} <br>
                    <strong>Rating:</strong> {{ $review->rating }} / 5 <br>
                    <strong>Description:</strong> {{ $review->description }} <br>
                </li>
            @endforeach
        </ul>
        </div>
        </div>
    </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


@endsection