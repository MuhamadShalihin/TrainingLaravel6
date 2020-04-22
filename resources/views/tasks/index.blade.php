@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="col-md-12">
            <button class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">Filter</button>
            <a href="tasks/create" class="btn btn-primary">Create</a>
            <a href="/tasks/excel?{{ $paramString }}" class="btn btn-primary">
                <span class="oi oi-file" style="color: white"></span> Export
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of tasks</div>

                <div class="card-body">

                    @if($tasks->isEmpty())
                    <p> There is no tasks</p>
                    @else

                    <table class="table">
                        <thead>
                            <th>&nbsp;</th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{($tasks->currentPage()-1) * $tasks->perPage() + $loop->index + 1}}</td>
                                <td>{{$task->id}}</td>
                                <td>{{$task->name}}</td>
                                <td>{{$task->category}}</td>
                                <td>{{$task->user->name}}</td>
                                <td>{{$task->user->email}}</td>
                                <td>
                                    <a href="/tasks/{{$task->id}}">
                                        <span class="oi oi-eye" title="icon star" aria-hidden="true" style="color: blue"></span>
                                    </a>
                                    &nbsp;
                                    <a href="/tasks/{{$task->id}}">
                                    </a>
                                    <form action="tasks/{{$task->id}}" method="post">
                                        {{method_field('DELETE')}}
                                        @csrf
                                        <button type="submit">
                                            <span class="oi oi-trash" title="icon star" aria-hidden="true" style="color: red"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    {{ $tasks->appends((array)$params)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Filtered Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-12">
                        <form action="/tasks" method="GET">
                            <fieldset>
                                <div class="form-group">
                                    <label for="" class="col-lg-12 control-label">Name</label>
                                    <div class="col-lg-12">
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-lg-12 control-label">Owner</label>
                                    <div class="col-lg-12">
                                        <div class="col-lg-12">
                                            {{Form::select('user_id', $input, isset($params->user_id)? $params->user_id: '', ['class' => 'form-control'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-lg-12 control-label">Email</label>
                                    <div class="col-lg-12">
                                        <div class="col-lg-12">
                                            {{Form::select('email', $inputEmail, isset($params->email)? $params->email: '', ['class' => 'form-control'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection