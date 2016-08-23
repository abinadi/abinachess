<template>
    <section id="gamePlay" v-autoscroll="moves">
    <table class="table table-striped">
        <thead>
        <th>&nbsp;</th>
        <th>White ({{white}})</th>
        <th>Black ({{black}})</th>
        <thead>
        <tbody>
            <tr v-for="(index, move) in moves">
                <td>{{ index + 1 }}</td>
                <td>{{ move.white }}</td>
                <td>{{ move.black }}</td>
            </tr>
        </tbody>
    </table>
    </section>
</template>

<script type="text/babel">
export default {
    props: ['moves','white','black'],

    ready() {
    }
}
</script>

<style>
    #gamePlay {
        height: 380px;
        max-height: 380px;
        overflow: scroll;
    }
</style>
