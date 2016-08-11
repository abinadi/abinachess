
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.directive('autoscroll', {
    update() {
        this.el.scrollTop = this.el.scrollHeight;
    }
});

Vue.component('alert', require('./components/Alert.vue'));
Vue.component('game-history', require('./components/GameHistory.vue'));
Vue.component('shoutbox', require('./components/Shoutbox.vue'));
Vue.component('chess', require('./components/Chess.vue'));

var app = new Vue({
    el: 'body',

	events: {
		'shout-alert': function(alertObj) {
			this.$broadcast('alert', alertObj);
		},
		'game-alert': function(alertObj) {
			this.$broadcast('alert', alertObj);
		}
	}
});
