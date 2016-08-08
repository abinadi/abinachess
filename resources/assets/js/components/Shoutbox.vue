<template>
    <section id="shoutbox-area">
        <ul class="list-group">
            <li v-for="shout in shouts">
                <strong>{{ shout.name }}</strong>: {{ shout.shout }}
            </li>
        </ul>
        <input type="text" @keyup.enter="shoutIt" v-model="shout" placeholder="Type something here...">
    </section>
</template>

<script type="text/babel">
export default {
    data() {
        return {
            shouts: [],
			shout: '',
            uid: gameUid,
			player: player,
			color: color
        }
    },

    methods: {
        getShoutsFromServer() {
            this.$http.get('/api/shouts/' + this.uid)
                .then((response) => {
                    this.shouts = response.data;
                }, (response) => {

                });
        },
		
		shoutIt(event) {
            console.log(this.shout);

			var payload = {
				name: this.player,
				shout: event.target.value
			};

			this.$http.post('/api/shouts/' + this.uid, payload)
				.then((response) => {
				    this.shouts.push({name: this.player, shout: this.shout});
                    this.shout = '';
				}, (response) => {
					console.log(response);
				});
		},

        listen() {
            echo.channel('abinachess_shout.' + this.uid)
                .listen('ShoutWasPosted', event => {
                    console.log(event);
                    this.shouts.push(event.shout);
                });
        }

    },

    ready() {
        this.getShoutsFromServer();

        this.listen();
    }
}
</script>

<style>
    #shoutbox-area {
        height: 380px;
        max-height: 380px;
        overflow: scroll;
    }

    #shoutbox-area ul li:nth-child(odd) {
        background-color: #CCC;
    }
</style>
