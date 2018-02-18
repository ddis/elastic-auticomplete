@extends('layouts.main')
@section('title', 'Search Page')

@section('content')
    <h3>Search Query</h3>
    <form>
        <div class="form-group">
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter query">
        </div>
    </form>

    <h3>Result</h3>

    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action">Cras <em style="color: #2ab27b">jus</em>to odio</a>
        <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
    </div>

@stop