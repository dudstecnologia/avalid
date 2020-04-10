<template>
    <span>
        <h1>Dashboard Admin</h1>
    </span>
</template>

<script>
import Layout from '../../../Componentes/Layout'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    props: [
        'auth'
    ],
    data () {
        return {

        }
    }
}
</script>
