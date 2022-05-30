<h1>Olá</h1>

@forelse ($tidings as $tiding)
    <li>{{ $tiding->title }}</li>
@empty
    <p>No tidings</p>
@endforelse