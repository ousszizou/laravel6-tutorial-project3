<template>
    <div>
        <h1>Dashboard</h1>
        <div v-if="user">
            {{ user.name }}
        </div>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
    computed: mapGetters({
        user: 'auth/user'
    })
}
</script>
