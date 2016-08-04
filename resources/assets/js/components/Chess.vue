<template>
    <div id="board" class="col-md-8"></div>
</template>

<script type="text/babel">
export default {
    ready() {
        console.log('Component ready.');
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
            board.position(game.fen());
        }

        var gamePlay = function(history) {
            var lastMove = history.pop();
            var player = (history.length % 2 == 0) ? 'w' : 'b';

            if(player == 'w') {
                $("#moves tbody").append('<tr id="move_' + history.length + '"><td>' + lastMove + '</td></tr>');
            } else {
                $("#moves tbody #move_" + (history.length - 1)).append('<td>' + lastMove + '</td>');
            }
        }

        var options = {
            draggable: true,
            position: 'start',
            onDrop: onDrop,
            onSnapEnd: onSnapEnd
        };

        var board = ChessBoard('board', options)
    }
}
</script>
