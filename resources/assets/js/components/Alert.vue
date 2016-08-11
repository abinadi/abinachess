<template>
    <div class="alert alert-{{ type }}" v-show="show" transition="fade">
        <slot></slot>
        <span
            class="alert-close"
            v-show="important"
            @click="show = false"
        >
            &times;
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            type: { default: 'info' },
            timeout: { default: 5000 },
            important: { type: Boolean, default: false }
        },

        data() {
            return {
                show: false
            };
        },

        events: {
            'new-alert': function(alertObj) {
                this.type = alertObj.type;
                this.show = true;
                this.important = alertObj.import;

                this.fadeAway();
            }
        },

        methods: {
            fadeAway() {
                if ( ! this.important) {
                    setTimeout(
                        () => this.show = false,
                        this.timeout
                    )
                }
            }
        },

        ready() {
        }
    }
</script>

<style>
    .alert {
        position: absolute;
        top: 2em;
        right: 2em;
        z-index: 999;
        padding-right: 1.5em;
    }

    .alert-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .fade-transition {
        transition: opacity .5s ease;
    }

    .fade-leave {
        opacity: 0;
    }
</style>
