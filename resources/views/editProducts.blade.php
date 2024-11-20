@extends('index')

@section('content')

<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Edit Product</h4>
        <form class="forms-sample" method="POST" action="{{ route('productEdit') }}"  enctype="multipart/form-data">
            @csrf
            <input type="text" hidden class="form-control" name="ID" id="ID" placeholder="ID" value="{{ $productsData['ID'] }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ $productsData['name'] }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" placeholder="Price" name="price" value="{{ $productsData['price'] }}" required>
            </div>


            <div class="form-group">
                <label for="image">Image</label>
                <div class="input-group col-xs-12">
                    <input type="file" class="form-control file-upload-info" name="image" id="image" placeholder="Upload Banner">
                </div>

                @if($productsData['image_url'])
                    <div class="mt-2">
                        <img src="{{ asset($productsData['image_url']) }}" alt="Current Image" width="100">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="link">Description</label>
                <textarea id="description" name="description" placeholder="Enter Description" class="ckeditor form-control">{{ $productsData['description'] }}</textarea>     
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>


        </div>
    </div>
</div>

@endsection