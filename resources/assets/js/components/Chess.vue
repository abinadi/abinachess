<template>
    <div id="board" class="col-md-8"></div>

    <aside id="sidebar" class="col-md-4">
        <section id="gameUid">
            <h2>GAME UID</h2>
        </section>

        <game-history :moves="history"></game-history>

        <shoutbox></shoutbox>
    </aside>
</template>

<script type="text/babel">
export default {
    data() {
        return {
            history: []
        };
    },

    ready() {
        // This keeps track of the game (all the moves, etc)
        var game = new Chess();

        // Get a handle to use `this` inside of functions
        var that = this;

        // Options to create the chess board
        var options = {
            draggable: true,
            position: 'start',
            onDrop: onDrop,
            onSnapEnd: onSnapEnd
        };

        // Create the chess board using the aforementioned options
        var board = ChessBoard('board', options);

        /*
         * When a piece is dropped, check it is a valid move
         * If it is, allow it and update the history (which will be broadcast to the child component that displays
         * the moves in algebraic notation).
         * Otherwise, don't allow it.
         */
        var onDrop = function(source, target) {
            var move = game.move({
                from: source,
                to: target,
                promotion: 'q'
            });

            if (move == null) {
                return 'snapback';
            }

            that.history = historyToArrayOfObjects(game.history());
        };

        /*
         * Once the move is deemed legit, update the whole board ... this is to account for things
         * like castleing and en-passant, etc.
         */
        var onSnapEnd = function() {
            board.position(game.fen());
        }

        /*
         * Convert the history array into a more workable array of objects that looks like this (example):
         * [
         *      { white: 'e4', black: 'e5' },
         *      { white: 'Nf3', black: 'Nc6' },
         *      ...
         * ]
         */
        var historyToArrayOfObjects = function(history) {
            var historyObject = [];

            for(var i = 0; i < history.length; i+=2) {
                if(history[i+1] == undefined) {
                    history[i+1] = '';
                }

                historyObject.push({white: history[i], black: history[i+1]});
            };

            return historyObject;
        };
    }
}
</script>

