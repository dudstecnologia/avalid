<template>
    <span>
        <h1>Dashboard</h1>
        <inertia-link href="/logout">Sair</inertia-link>
    </span>
</template>

<script>
import Layout from '../../Componentes/Layout'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    data () {
        return {

        }
    }
}
</script>
