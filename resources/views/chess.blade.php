@extends('master')

@section('style')
    @parent

    <link rel="stylesheet" href="/js/chessboardjs/css/chessboard-0.3.0.css">
@endsection

@section('content')

    <div class="container">
        <chess></chess>

        <aside id="sidebar" class="col-md-4">
            <section id="gameUid">
                <h2>GAME UID</h2>
            </section>

            <section id="gamePlay">
                <h2>Moves</h2>

                <table class="table table-striped" id="moves">
                <thead>
                    <th>White</th>
                    <th>Black</th>
                <thead>
                <tbody>
                </tbody>
                </table>
            </section>
        </aside>
    </div>

@endsection

@section('script-footer')
    <script src="/js/chessboardjs/js/chessboard-0.3.0.js"></script>
    <script src="/js/chessjs/chess.js"></script>

    @parent
@endsection
