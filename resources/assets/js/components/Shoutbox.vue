<template>
    <section id="shoutbox-area">
        <h2>Chat</h2>

        <ul>
            <li v-for="shout in shouts">
                <strong>{{ shout.name }}</strong>: {{ shout.shout }}
            </li>
        </ul>
        <input type="text" name="shout">
    </section>
</template>

<script type="text/babel">
export default {
    data() {
        return {
            shouts: [],
            uid: gameUid
        }
    },

    methods: {
        getShoutsFromServer: function() {
            this.$http.get('/api/shouts/' + this.uid)
                .then((response) => {
                    this.shouts = response.data;
                }, (response) => {

                });
        }
    },

    ready() {
        this.getShoutsFromServer();
    }
}
</script>

