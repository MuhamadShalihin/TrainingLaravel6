@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b>
                        <h4>Create Tasks</h4>
                    </b>
                </div>
                <div class="card-body">
                    <form method="POST" action="/tasks/create">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-12 control-label">Owner</label>
                            <div class="col-lg-12">
                                <div class="col-lg-16">
                                    {{Form::select('user_id', $input, isset($params->user_id)? $params->user_id: '', ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection