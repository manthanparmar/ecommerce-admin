@extends('index')

@section('content')
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Products</h4>
        <!-- <p class="card-description"> Basic form layout </p> -->
        <form class="forms-sample" method="POST" action="{{ route('productsCreate') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="title">Name</label>
                <input type="text" class="form-control" id="name" placeholder="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="title">Price</label>
                <input type="number" class="form-control" id="price" placeholder="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <div class="input-group col-xs-12">
                    <input type="file" class="form-control file-upload-info" name="image" id="image"  placeholder="Upload Banner" required>
                </div>
            </div>

            <div class="form-group">
                <label for="link">Description</label>
                <textarea id="description" name="description" placeholder="Enter Description" class="ckeditor form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Products List</h4>
        <!-- <p class="card-description"> Add class <code>.table</code> -->
        </p>
        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                <th>#</th>
                <th>Name</th>
                <th>price</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($productsData as $key => $addValue)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$addValue['name']}}</td>
                        <td>{{$addValue['price']}}</td>
                        <td><img src="{{ asset($addValue['image_url']) }}" alt="Banner"></td>
                        <td><a href="{{ route('getProducts', ['addId' => $addValue['ID']]) }}"><label class="btn btn-primary btn-fw">Edit</label></a></td>
                        <td>
                            <form id="delete-form-{{ $addValue['ID'] }}" action="{{ route('deleteProducts', ['addId' => $addValue['ID']]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="confirmDelete({{ $addValue['ID'] }})" type="button" class="btn btn-danger btn-fw">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>

<script>
    function confirmDelete(addId) {
        if (confirm('Are you sure you want to delete this Products?')) {
            document.getElementById('delete-form-'+addId).submit();
        }
    }



</script>
@endsection