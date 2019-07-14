<template>

    <span v-if="friend.status == 'online'">
        <i class="fa fa-circle text-success" title="Ativo"></i> Online
    </span>

    <span v-else>
        <i class="fa fa-circle text-danger" title="Inativo"></i> Offline
    </span>

</template>

<script>
    export default {
        props: ['user', 'receiver'],
        data() {
            return {
                friend: this.receiver
            }
        },
        mounted() {
            this.listen();
            //this.listenForWhisper();
        },
        methods: {
            listen() {
                Echo.join('chat')
                    .joining((user) => {
                        axios.put('/user/'+ user.uuid +'/online', {});
                    })
                    .leaving((user) => {
                        axios.put('/user/'+ user.uuid +'/offline', {});
                    })
                    .listen('UserOnline', (e) => {
                        this.friend = e.user;
                    })
                    .listen('UserOffline', (e) => {
                        this.friend = e.user;
                    });
            }
        }
    }
</script>
