<template>

    <span v-if="friend.status == 'online'">
        <i class="fa fa-circle text-success" title="Ativo"></i>
    </span>

    <span v-else>
        <i class="fa fa-circle text-danger" title="Inativo"></i>
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
        },
        methods: {

            listen() {
                Echo.join('chat')
                    .joining((user) => {
                        axios.put('/api/user/'+ user.id +'/online', {}, {
                            headers: {
                                'Authorization':'Bearer ' + user.api_token,
                            }
                        });
                    })
                    .leaving((user) => {
                        axios.put('/api/user/'+ user.id +'/offline', {}, {
                            headers: {
                                'Authorization':'Bearer ' + user.api_token,
                            }
                        });
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
