@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (!isset($note) || $note === null)
                    <div class="card-header">Notes</div>
                @elseif ($note !== null)
                    <div class="card-header"><a href="{{ route('notes-list') }}"><</a>&nbsp;&nbsp;Note</div>
                @endif

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!isset($note) || $note === null)
                        @include('parts.notes-list')
                    @elseif ($note !== null)
                        @include('parts.note')
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
