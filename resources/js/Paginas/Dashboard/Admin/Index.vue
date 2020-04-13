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
            avaliacaoFuncionario: []
        }
    },
    mounted() {
        this.listarAvaliacoes()
    },
    methods: {
        listarAvaliacoes() {
            this.axios.get(this.route('admin.avaliacao-funcionario-listar'))
                .then(({data}) => {
                    console.log(data)
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>
