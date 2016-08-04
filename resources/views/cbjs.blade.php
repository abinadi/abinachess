@extends('layout')

@section('style')
    @parent

    <link rel="stylesheet" href="/js/chessboardjs/css/chessboard-0.3.0.css">
@endsection

@section('script-footer')
    @parent

	<script src="/js/chessboardjs/js/chessboard-0.3.0.js"></script>
    <script src="/js/chessjs/chess.js"></script>

	<script>
        var game = new Chess();
		var onDrop = function(source, target) {
			var move = game.move({
				from: source,
				to: target,
				promotion: 'q'
			});

			if (move == null) {
				return 'snapback';
			}

            gamePlay(game.history());
		};

		var onSnapEnd = function() {
		    board1.position(game.fen());
        }

		var board1 = ChessBoard('board1', {draggable:true, position: 'start', onDrop: onDrop, onSnapEnd: onSnapEnd});

        function gamePlay(history) {
            var lastMove = history.pop();
            var player = (history.length % 2 == 0) ? 'w' : 'b';

            if(player == 'w') {
                $("#moves tbody").append('<tr id="move_' + history.length + '"><td>' + lastMove + '</td></tr>');
            } else {
                $("#moves tbody #move_" + (history.length - 1)).append('<td>' + lastMove + '</td>');
            }
        }
	</script>
@endsection

@section('content')
    <div class="container">
    <div id="board1" class="col-md-8"></div>

    <aside id="gamePlay" class="col-md-4">
        <h2>Moves</h2>

        <table class="table table-striped" id="moves">
            <thead>
                <th>White</th>
                <th>Black</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </aside>
    </div>
@endsection
