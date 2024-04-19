@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student image Crud.
                            <a href="{{url('add-student')}}" class="btn btn-primary float-end">Add Student</a>
                        </h4>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Compare</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>
                                            <img src="{{asset('uploads/students/'.$item->profile_image)}}" width="70px" height="70px" alt="img">
                                        </td>
                                        <td>
                                            <a href="{{url('edit-student/'.$item->id)}}" class="btn btn-primary btm-sm">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{url('delete-student/'.$item->id)}}" class="btn btn-danger btm-sm">Delete</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success">Compare</a>
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
