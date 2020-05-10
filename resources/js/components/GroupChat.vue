<template>
    <div>
        <div class="card card-primary">
            <div class="card-heading justify-content-between mb-2" id="accordion">
                <span class="glyphicon glyphicon-comment"></span> {{ group.name }}
                <div class="btn-group pull-right">
                    <a class="btn btn-outline-primary btn-sm" data-toggle="collapse" :href="'#collapse' + group.id" role="button" aria-expanded="false">V</a>
                </div>
            </div>
            <div class="collapse multi-collapse" :id="'collapse' + group.id">
                <div class="card-body chat-card">
                    <ul class="chat">
                        <li v-for="conversation in conversations">
                            <!-- <span class="chat-img pull-left">
                                <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                            </span> -->
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{ conversation.user.name }}</strong>
                                </div>
                                <p>
                                    {{ conversation.message }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control form-control-sm" placeholder="Type your message here..." aria-label="Type your message here..." aria-describedby="button-addon2" v-model="message" @keyup.enter="store()" autofocus>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary" type="button" id="btn-chat" @click.prevent="store()">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GroupChat",
        props: ['group'],
        data() {
            return {
                conversations: [],
                message: '',
                group_id: this.group.id
            }
        },
        mounted() {
            this.listenForNewMessage();
        },
        methods: {
            store() {
                axios.post('conversations', {message: this.message, group_id: this.group.id})
                    .then((response) => {
                        this.message = '';
                        this.conversations.push(response.data);
                    });
            },
            listenForNewMessage() {
                Echo.private('groups.' + this.group.id)
                    .listen('NewMessage', (e) => {
                        // console.log(e);
                        this.conversations.push(e);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
