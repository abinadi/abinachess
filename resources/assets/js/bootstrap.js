window._ = require('lodash');
window.Cookies = require('js-cookie');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass/assets/javascripts/bootstrap');

/**
 * Vue is a modern JavaScript for building interactive web interfaces using
 * reacting data binding and reusable components. Vue's API is clean and
 * simple, leaving you to focus only on building your next great idea.
 */

window.Vue = require('vue');
require('vue-resource');

window.Pusher = require('pusher-js');

import Echo from "laravel-echo";

window.echo = new Echo({
    connector: 'pusher',
    pusherKey: 'd3b2371175bc87a5b41c', // dev
    // pusherKey: 'cd4bea636a1e2a99cfec', // prod
	namespace: 'AbinaChess.Events'
});

/**
 * We'll register a HTTP interceptor to attach the "XSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-XSRF-TOKEN'] = Cookies.get('XSRF-TOKEN');
    request.headers['X-Socket-Id'] = echo.socketId();

    next();
});
