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
            <h3>Transferir Saldo (Informe o Recebedor)</h3>
        </div>
        <div class="box-body">
        <form method="POST" action="{{route('transfer.confirm')}}">
                {!! csrf_field() !!}
              
              <div class="form-group">
                  <input type="text"  name="sender" placeholder="Recebedor (Nome ou E-mail)" class="form-control">
              </div>
               <div class="form-group">
                 <button class="btn btn-success" type="submit">Próxima Etapa</button>
              </div>

          </form>
        </div>
    </div>
@stop