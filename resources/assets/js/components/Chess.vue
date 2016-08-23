<template>
    <div class="col-md-8">
        <div id="board"></div>
    </div>

    <aside id="sidebar" class="col-md-4">
        <section id="gameUid">
            <h2>{{ uid }} <small class="pull-right">{{{ turn }}}</small></h2>
        </section>

        <game-history :moves="history" :white="whitePlayerName" :black="blackPlayerName"></game-history>

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
            whitePlayerName: null,
            blackPlayerName: null,
            opponent: null,
			turn: '',
            oturn: false,
            pturn: false,
            alertObj: {
                type: 'info',
                message: '',
                import: false
            }
        };
    },

    methods: {
        /*
         * When a piece is dropped, check it is a valid move
         * If it is, allow it and update the history (which will be broadcast to the child component that displays
         * the moves in algebraic notation).
         * Otherwise, don't allow it.
         */
        onDrop(source, target, piece, newPos, oldPos, orientation) {
            if(this.canMove() === false) {
                return 'snapback';
            }

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

            // Alerts for game situations
            this.gameChecks();
        },

        gameChecks() {
			var gameover = false;

            // baseline
            this.resetAlertObj();

            if(this.game.in_checkmate()) {
                this.alertObj.type = 'danger';
                this.alertObj.import = true;
                this.alertObj.message = 'Checkmate!!';
				gameover = true;
            } else if(this.game.in_check()) {
                this.alertObj.type = 'warning';
                this.alertObj.message = 'Check!';
            } else if(this.game.in_draw()) {
                this.alertObj.type = 'warning';
                this.alertObj.message = 'Draw';
				gameover = true;
            } else if(this.game.in_stalemate()) {
                this.alertObj.type = 'warning';
                this.alertObj.message = 'Stalemate';
				gameover = true;
			}

            // Update whose turn it is
            this.updateTurn(gameover);

            if(this.alertObj.message != '') {
                this.$dispatch('game-alert', this.alertObj);
            }
        },

        resetAlertObj() {
            this.alertObj = {
                type: 'info',
                message: '',
                import: false
            };
        },

        canMove() {
            if(this.oturn) {
                return false;
            }

            return true;
        },

        /*
         * Once the move is deemed legit, update the whole board ... this is to account for things
         * like castleing and en-passant, etc.
         */
        onSnapEnd() {
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
        historyToArrayOfObjects(history) {
            var historyObject = [];

            for(var i = 0; i < history.length; i+=2) {
                if(history[i+1] == undefined) {
                    history[i+1] = ' - ';
                }

                historyObject.push({white: history[i], black: history[i+1]});
            };

            return historyObject;
        },

        /*
         * When the page first loads, get the game and potential history from the server
         */
        getGameFromServer(uid) {
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

					this.gameChecks();
                    this.setPlayerNames();
                }, (response) => {
                    console.log('error');
                    console.log(response);
                });
        },

        /*
         * After each move you make, send that move to the server
         */
        sendMoveToServer(move) {
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
        updateBoard(g) {
            this.updateBoardByPGN(g.pgn);
        },

        updateBoardByPGN(pgn) {
            this.game.load_pgn(pgn);
            this.onSnapEnd();
            this.history = this.historyToArrayOfObjects(this.game.history());
        },

        updateTurn(gameover = null) {
            var img = '<img src="/img/chesspieces/wikipedia/' + this.game.turn() + 'N.png"> ';

            if((this.game.turn() == 'b' && this.color == 'black') || (this.game.turn() == 'w' && this.color == 'white')) {
				this.turn = img + this.name + "'s turn";
                this.pturn = true;
                this.oturn = false;
            } else {
				this.turn = img + this.opponent + "'s turn";
                this.pturn = false;
                this.oturn = true;
            }

			if(gameover) {
				this.turn = 'Game Over';
			}
        },

        setPlayerNames() {
            if(this.color == "white") {
                this.whitePlayerName = this.name;
                this.blackPlayerName = this.opponent;
            } else {
                this.whitePlayerName = this.opponent;
                this.blackPlayerName = this.name;
            }
        },

        listen() {
            echo.channel('abinachess_move.' + this.uid)
                .listen('MoveWasMade', function(event) {
                    this.updateBoardByPGN(event.pgn);
                    this.updateTurn();
                    this.gameChecks();
                }.bind(this));
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

        // Check if the game is over, whose turn, etc.
		this.gameChecks();

        // listen for incoming moves
        this.listen();
    }
}
</script>

<style>
    .active {
        background-color: crimson;
        color: #ffffff;
        font-weight: bold;
    }

    #gameUid small img {
        width: 25px;
        height: 25px;
        vertical-align: text-bottom;
    }
</style>
