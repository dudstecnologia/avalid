<template>
    <span>
        <div class="row mt-2">
            <div class="col-md-10">
                <h3>Usuários</h3>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary">Novo Usuário</button>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <b-table striped hover :items="users.data"></b-table>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <paginacao :data="users" />
            </div>
        </div>
    </span>
</template>

<script>
import Layout from '../../Componentes/Layout'
import Paginacao from '../../Componentes/Paginacao'

export default {
    metaInfo: { title: 'Usuários' },
    layout: Layout,
    components: {
        Paginacao
    },
    props: {
        users: Object,
    },
    data () {
        return {

        }
    }
}
</script>
