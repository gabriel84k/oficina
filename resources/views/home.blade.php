@extends('layouts.app')

@section('content')
        @if (Auth::user()->cliente)
            
                <index  :user="{{Auth::user()}}"
                        :cliente="{{Auth::user()->cliente}}"
                        :permiso="{{Auth::user()->permisos}}"
                        :empresa="{{Auth::user()->empresa}}"
                ></index> 
            
        @else
                <index  :user="{{Auth::user()}}"
                        :permiso="{{Auth::user()->permisos}}"
                        :empresa="{{Auth::user()->empresa}}"
                ></index>     
        
        @endif
        

@endsection
