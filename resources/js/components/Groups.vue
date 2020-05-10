<template>
    <div>
        <group-chat v-for="group in groups" :group="group" :key="group.id"></group-chat>
    </div>
</template>

<script>
    export default {
        name: "Groups",
        props: ['initialGroups', 'user'],
        data() {
            return {
                groups: []
            }
        },
        mounted() {
            this.groups = this.initialGroups;
            this.$on('groupCreated', (group) => {
                this.groups.push(group);
            });
            this.listenForNewGroups();
        },
        methods: {
            listenForNewGroups() {
                Echo.private('users.' + this.user.id)
                    .listen('GroupCreated', (e) => {
                        this.groups.push(e.group);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
