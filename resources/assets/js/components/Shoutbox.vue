<template>
    <alert>{{ alertObj.message }}</alert>

    <section id="shoutbox-area">
        <ul class="list-group" v-autoscroll="shouts">
            <li v-for="shout in shouts">
                <strong>{{ shout.name }}</strong>: {{ shout.shout }}
            </li>
        </ul>
        <input type="text" @keyup.enter="shoutIt" v-model="shout" class="form-control" placeholder="Type something here...">
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
			color: color,
            alertObj: {
                type: 'info',
                message: '',
                import: false
            }
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
                .listen('ShoutWasPosted', function(event) {
                    this.shouts.push(event.shout);

                    this.alertObj.message = 'New chat';
                    this.$broadcast('shout-alert', this.alertObj);
                }.bind(this));
        }
    },

    ready() {
        this.getShoutsFromServer();

        this.listen();
    }
}
</script>

<style>
    #shoutbox-area ul {
        height: 350px;
        max-height: 350px;
        overflow: scroll;
    }

    #shoutbox-area ul li:nth-child(odd) {
        background-color: #CCC;
    }
</style>
