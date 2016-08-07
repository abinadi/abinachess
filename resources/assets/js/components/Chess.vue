<template>
    <div id="board" class="col-md-8"></div>

    <aside id="sidebar" class="col-md-4">
        <section id="gameUid">
            <h2>Game UID: {{ uid }}</h2>
        </section>

        <game-history :moves="history"></game-history>

        <shoutbox></shoutbox>
    </aside>
</template>

<script type="text/babel">
export default {
    data() {
        return {
            history: [],
            game: null,
            board: null,
            uid: gameUid
        };
    },

    methods: {
        /*
         * When a piece is dropped, check it is a valid move
         * If it is, allow it and update the history (which will be broadcast to the child component that displays
         * the moves in algebraic notation).
         * Otherwise, don't allow it.
         */
        onDrop: function(source, target) {
            var move = this.game.move({
                from: source,
                to: target,
                promotion: 'q'
            });

            if (move == null) {
                return 'snapback';
            }

            this.history = this.historyToArrayOfObjects(this.game.history());
        },

        /*
         * Once the move is deemed legit, update the whole board ... this is to account for things
         * like castleing and en-passant, etc.
         */
        onSnapEnd: function() {
            this.board.position(this.game.fen());
        },

        /*
         * Convert the history array into a more workable array of objects that looks like this (example):
         * [
         *      { white: 'e4', black: 'e5' },
         *      { white: 'Nf3', black: 'Nc6' },
         *      ...
         * ]
         */
        historyToArrayOfObjects: function(history) {
            var historyObject = [];

            for(var i = 0; i < history.length; i+=2) {
                if(history[i+1] == undefined) {
                    history[i+1] = '';
                }

                historyObject.push({white: history[i], black: history[i+1]});
            };

            return historyObject;
        }
    },

    ready() {
        // Have chess.js keep track of the game play
        this.game = new Chess();

        // Options to create the chess board
        var options = {
            draggable: true,
            position: 'start',
            onDrop: this.onDrop,
            onSnapEnd: this.onSnapEnd
        };

        // Create the chess board using the aforementioned options
        this.board = ChessBoard('board', options);
    }
}
</script>

