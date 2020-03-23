<template>
    <b-pagination
        v-model="data.current_page"
        :total-rows="data.total"
        :per-page="data.per_page"
        aria-controls="my-table">

        <template v-slot:first-text><div @click="navegar(data.first_page_url || '#')">Primeiro</div></template>
        <template v-slot:prev-text><div @click="navegar(data.prev_page_url || '#')">Anterior</div></template>
        <template v-slot:next-text><div @click="navegar(data.next_page_url || '#')">Próximo</div></template>
        <template v-slot:last-text><div @click="navegar(data.last_page_url || '#')">Último</div></template>

        <template class="teste" v-slot:page="{ page, active }">
            <div v-if="active" @click="navegar(data.path + '?page=' + page)">
                {{ page }}
            </div>
            <div v-else @click="navegar(data.path + '?page=' + page)">
                {{ page }}
            </div>
        </template>
    </b-pagination>
</template>

<script>
export default {
    props: {
        data: Object
    },
    data() {
        return {

        }
    },
    methods: {
        navegar(url) {
            this.$inertia.visit(url)
        }
    }
}
</script>

<style>
    .pagination .page-link {
        padding: 0;
    }

    .pagination .page-link div {
        padding: 0.5rem 0.75rem;
    }
</style>
