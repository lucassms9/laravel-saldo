@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1>Histórico de Movimentações</h1>

    <ol class="breadcrumb">
    <li><a href="#">Dashboard</a></li>
        <li><a href="#">Histórico de Movimentações</a></li>
    </ol>
@stop

@section('content')
    <div class="box">

        <div class="box-header">
        <form action="{{route('historic.search')}}" method="POST" class="form form-inline">

            {!! csrf_field() !!}

            <input type="text" name="id" class="form-control" placeholder="ID" >
            <input type="date" name="date" class="form-control" >
            <select  name="type" class="form-control">
                <option value="">-- Selecione --</option>
                
                @foreach($types as $key => $type)
                
                
                <option value=" {{$key}} "> {{$type}} </option>

                @endforeach

            </select>
            <button class="btn btn-primary">Filtrar</button>
        </form>
        </div>

        <div class="box-body">
              <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                          <th>#</th>
                          <th>Valor</th>
                          <th>Tipo</th>
                          <th>Data</th>
                          <th>Sender</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                      @forelse($historics as $historic)
                    <tr>
                        <th> {{$historic->id}} </th>
                        <th> {{number_format($historic->amount, '2' , ',' , '.')}} </th>
                        <th> {{$historic->type($historic->type)}} </th>
                        <th> {{$historic->date}} </th>
                        <th>
                            
                            @if($historic->user_id_transaction)
                            {{$historic->userSender->name}}
                            @else

                            @endif

                            
                            
                        </th>

                    </tr>
                    @empty
                    @endforelse
                  </tbody>
              </table>
            
              @if(isset($dataForm))
            
              {!! $historics->appends($dataForm)->links() !!}
              @else
              {!! $historics->links() !!}
              @endif

        </div>
    </div>
@stop