<template>
    <ul class="card list-group list-group-flush">
        <li class="list-group-item mb-1" v-for="message in messages" style="padding:0 .75rem !important;">
            <h6 class="text-wrap" :class="{ 'float-right text-right text-info': message.user.id === user.id }">
                <strong>{{ message.message }}</strong>
                <br>
                <small>{{ message.user.name }}</small>
            </h6>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "ChatMessages",
        props: ['messages', 'user']
    }
</script>

<style scoped>

</style>
