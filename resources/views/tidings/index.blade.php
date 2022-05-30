@extends('layouts.app')

@section('title', 'Listagem de notícias')
 
@section('styles')
    <style>    
        .text-justify {
            text-align: justify;
        }

        .tiding {
            height: 160px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-8">
                <h1 class="mb-5">Notícias ({{ $tidings->total() }})</h1>
            </div>    
            <div class="col-4 d-flex justify-content-end">
                @if($tidings->total() == 0)
                    <form method="post" action="{{ route('scrapers.scrap') }}" class="me-2">
                        @csrf
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                @else
                    <form method="post" class="delete-tidings" action="{{ route('tidings.deleteAll') }}">
                        @method('DELETE')    
                        @csrf
                        <button type="submit" class="btn btn-danger">Excluir todas notícias</button>
                    </form>
                @endif
            </div>
        </div>
        @forelse ($tidings as $tiding)
            <div class="row mb-5 rounded bg-light p-3 tiding"> 
                <div class="col-10">
                    <h3 class="text-justify">{{ $tiding->title }}</h3>
                </div>
                <div class="col-2 text-justify text-muted">
                    {{ $tiding->posted_at->format('d/m/Y H:i') }}
                </div>
                <div class="col-12 text-justify">
                    <a href="{{ $tiding->link }}" target="_blank">Clique aqui</a> para ler mais.
                </div>
            </div>
        @empty
            <p>Sem notícias até o momento!</p>
        @endforelse

        @if($tidings->total() > 0)
            {{ $tidings->links() }}
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelector('form button.btn-danger').addEventListener('click', function(event) {
            event.preventDefault();

            swal({
                dangerMode: true,
                title: 'Você tem certeza disso?',
                text: 'Todas as notícias serão excluídas permanentemente!',
                icon: 'warning',
                buttons: ["Não, cancele essa ação!", "Sim, eu aceito!"],
            }).then(function(value) {
                if (value) {
                    document.querySelector('form.delete-tidings').submit();
                }
            });
        });
   </script>
@endsection