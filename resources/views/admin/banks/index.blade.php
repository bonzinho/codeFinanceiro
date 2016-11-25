@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h2>Lista</h2>
            <a href="{{ route('admin.banks.create') }}" class="btn waves-effect">Inserir Banco</a>
            <table class="bordered striped hi centered responsive-table z-deth-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>                        
                        <th>Acções</th>                        
                    </tr>
                </thead>
                <tbody>
                @foreach($banks as $bank)                
                    <tr>
                        <td>{{$bank->id}}</td>
                        <td>{{$bank->name}}</td> 
                        <td>Acções</td>                                              
                    </tr>  
                @endforeach            
                </tbody>
            </table>
            {!! $banks->links() !!}
        </div>
    </div>
@endsection