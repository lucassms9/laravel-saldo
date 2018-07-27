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
        <div class="box-header">
            <h3>Fazer Recarga</h3>
        </div>
        <div class="box-body">
        <form method="POST" action="{{route('deposit.store')}}">
                {!! csrf_field() !!}
              <div class="form-group">
                  <input type="number"  name="value" placeholder="Valor Recarga" class="form-control" required>
              </div>
               <div class="form-group">
                 <button class="btn btn-success" type="submit">Recarregar</button>
              </div>

          </form>
        </div>
    </div>
@stop