@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>

    <ol class="breadcrumb">
        <li><a"#">Dashboard</a></li>
        <li><a href="#">Saldo</a></li>
    </ol>
@stop

@section('content')
    <div class="box">


        @include('admin.includes.alerts')

        <div class="box-header">
            <h3>Fazer Retirada</h3>
        </div>
        <div class="box-body">
        <form method="POST" action="{{route('withdraw.store')}}">
                {!! csrf_field() !!}
              <div class="form-group">
                  <input type="number"  name="value" placeholder="Valor Retirada" class="form-control">
              </div>
               <div class="form-group">
                 <button class="btn btn-success" type="submit">Sacar</button>
              </div>

          </form>
        </div>
    </div>
@stop