<template>
    <span v-if="user.status == 'online'">
        <i class="mdi mdi-star-circle member-star text-success" title="Ativo"></i> Online
    </span>

    <span v-else>
        <i class="mdi mdi-alert-circle-outline member-star text-danger" title="Inativo"></i> Offline
    </span>

</template>

<script>
    export default {
        props: ['user', 'user2'],
        data() {
            return {
                friend: this.user2
            }
        },
        mounted() {
            this.listen();
        },
        methods: {
            listen() {
                Echo.join('chat')
                    .joining((user) => {
                        axios.put('/api/user/'+ user.uuid +'/online', {});
                    })
                    .leaving((user) => {
                        axios.put('/api/user/'+ user.uuid +'/offline', {});
                    })
                    .listen('UserOnline', (e) => {
                        this.user = e.user;
                    })
                    .listen('UserOffline', (e) => {
                        this.user = e.user;
                    });
            }
        }
    }
</script>
