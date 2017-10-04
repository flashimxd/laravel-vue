@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Novo Banco</h4>
            {!! Form::open(['route' => 'admin.banks.store', 'files' => true]) !!}
                @include('admin.banks._form')
                <div class="row">
                    {!! Form::submit('Criar Banco', ['class' => 'btn waves-effect']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsections