@extends('master')

@section('style')
    @parent

    <link rel="stylesheet" href="/js/chessboardjs/css/chessboard-0.3.0.css">
@endsection

@section('content')

    <div class="container">
		<alert></alert>

        <chess></chess>
    </div>

@endsection

@section('script-footer')
    <script src="/js/chessboardjs/js/chessboard-0.3.0.js"></script>
    <script src="/js/chessjs/chess.js"></script>
    <script>
        var gameUid = '{{ $game->uid }}';
        var color = '{{ $color }}';
		var player = '{{ $game->$color }}';
    </script>

    @parent
@endsection
