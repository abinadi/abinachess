<template>
    <section id="shoutbox-area">
        <ul class="list-group" v-autoscroll="shouts" :class="{'glow': glow}">
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
            },
			glow: false
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
					setTimeout((function() { this.glow = false; }).bind(this),3000);
					this.glow = false;
                    this.shouts.push(event.shout);

                    this.alertObj.message = 'New chat';
                    this.$dispatch('shout-alert', this.alertObj);
					setTimeout((function() { this.glow = true; }).bind(this),500);
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
		transition: all 3s ease;
    }

    #shoutbox-area ul li:nth-child(odd) {
        background-color: #CCC;
    }

	@keyframes glower {
		0% {
			box-shadow: none;
		}
		65% {
			box-shadow: 0 0 15px 15px rgba(255,255,190,.75);
		}
		100% {
			box-shadow: none;
		}
	}

	.glow {
		animation-name: glower;
		animation-duration: 3s;
	}
</style>
