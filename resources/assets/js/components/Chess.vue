<template>
    <div class="col-md-8">
        <p class="player_opponent" v-bind:class="{ 'active' : oturn }">{{ opponent }}</p>
        <div id="board"></div>
        <p class="player_name" v-bind:class="{ 'active' : pturn }">{{ name }}</p>
    </div>

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
            uid: gameUid,
            color: color,
            name: player,
            opponent: null,
            oturn: false,
            pturn: false
        };
    },

    methods: {
        /*
         * When a piece is dropped, check it is a valid move
         * If it is, allow it and update the history (which will be broadcast to the child component that displays
         * the moves in algebraic notation).
         * Otherwise, don't allow it.
         */
        onDrop: function(source, target, piece, newPos, oldPos, orientation) {
            var move = this.game.move({
                from: source,
                to: target,
                promotion: 'q'
            });

            if (move == null) {
                return 'snapback';
            }

            // Update game history section
            this.history = this.historyToArrayOfObjects(this.game.history());

            // Send move to server
            this.sendMoveToServer(move);

            // Update whose turn it is
            this.updateTurn();
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
        },

        /*
         * When the page first loads, get the game and potential history from the server
         */
        getGameFromServer: function (uid) {
            this.$http.get('/api/game/' + uid)
                .then((response) => {
                    if(response.data.pgn != null) {
                        this.updateBoard(response.data);
                    }
                    var w = response.data.white;
                    var b = response.data.black;
                    if(w == this.name) {
                        this.opponent = b;
                    } else {
                        this.opponent = w;
                    }
                }, (response) => {
                    console.log('error');
                    console.log(response);
                });
        },

        /*
         * After each move you make, send that move to the server
         */
        sendMoveToServer: function (move) {
            this.$http.post('/api/game/' + this.uid, {move:move})
                .then((response) => {
                    // success
                }, (response) => {
                    // error
                    console.log('error');
                    console.log(response);
                });
        },

        /*
         * After getting the game from the server, update the board to reflect the current position
         */
        updateBoard: function(g) {
            this.game.load_pgn(g.pgn);
            this.onSnapEnd();
            this.history = this.historyToArrayOfObjects(this.game.history());
        },

        updateTurn: function(){
            if((this.game.turn() == 'b' && this.color == 'black') || (this.game.turn() == 'w' && this.color == 'white')) {
                this.pturn = true;
                this.oturn = false;
            } else {
                this.pturn = false;
                this.oturn = true;
            }
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
            onSnapEnd: this.onSnapEnd,
            orientation: this.color
        };

        // Create the chess board using the aforementioned options
        this.board = ChessBoard('board', options);

        // Bring in game from the server
        this.getGameFromServer(this.uid);

        // whose turn is it?
        this.updateTurn();
    }
}
</script>

<style>
    .active {
        background-color: crimson;
        color: #ffffff;
        font-weight: bold;
    }
</style>
