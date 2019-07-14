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
        props: ['user'],
        data() {
            return {

            }
        },
        mounted() {
            this.listen();
        },
        methods: {
            listen() {
                Echo.join('chat')
                    .joining((user) => {
                        axios.get('/user/'+ user.uuid +'/online', {});
                    })
                    .leaving((user) => {
                        axios.get('/user/'+ user.uuid +'/offline', {});
                    })
            }
        }
    }
</script>
