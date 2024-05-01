@extends('layouts.app')
@section('content')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                    <h6 class="alert alert-success">{{session('status')}}</h6>

                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>edit student with image
                            <a href="{{url('students')}}" class="btn btn-danger float-end">Back</a>
                        </h4>
                        <div class="card-body">

                            <form action="{{url('update-student/'.$student->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 ">
                                    <label for="name">Student Name</label>
                                    <input type="text" name="name" value="{{$student->name}}" class="form-control">
                                </div>
                                <div class="form-group mb-3 ">
                                    <label for="">phone</label>
                                    <input type="text" name="phone" value="{{$student->phone}}" class="form-control">
                                </div>
                                <div class="form-group mb-3 ">
                                    <label for="">profile_image</label>
                                    <input type="file" name="profile_image"  class="form-control">
                                    <img src="{{asset('uploads/students/'.$student->profile_image)}}" width="70px" height="70px" alt="img">

                                </div>
                                <div class="form-group mb-3 ">
                                    <button type="submit" class="btn btn-primary">Update Student</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
