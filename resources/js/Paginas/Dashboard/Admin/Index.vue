<template>
    <div class="mt-3">
        <b-overlay :show="progresso">
            <b-card no-body>
                <b-tabs card v-model="abaAtiva">
                    <b-tab v-for="a in avFuncionarios" :key="a.avaliacao_funcionario" :title="tituloAba(a.titulo_avaliacao, a.periodo)">
                        <b-card-text>
                            <div>
                                <b-button variant="primary" size="sm">Gerar Relatório</b-button>
                                <b-button v-if="a.status == 0" variant="danger" size="sm">Finalizar Avaliação</b-button>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    Tab contents 1    
                                </div>
                            </div>
                        </b-card-text>
                    </b-tab>
                </b-tabs>
                <p v-if="avFuncionarios.length == 0 && progresso == false" class="text-center">
                    Nenhuma avaliação encontrada
                </p>
            </b-card>
        </b-overlay>
    </div>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import moment from 'moment'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    props: [
        'auth'
    ],
    data () {
        return {
            progresso: true,
            abaAtiva: null,
            avFuncionarios: [],
            avaliacaoSelecionada: null,
            avaliados: {}
        }
    },
    mounted() {
        this.listarAvaliacoes()
    },
    methods: {
        listarAvaliacoes() {
            this.axios.get(this.route('admin.avaliacao-funcionario-listar'))
                .then(({data}) => {
                    this.avFuncionarios = data.avaliacoesFuncionarios
                    this.progresso = false
                })
                .catch(err => {
                    console.log(err)
                    this.progresso = false
                })
        },
        listarAvaliados(indice) {
            // console.log(this.avFuncionarios[indice])
            let af = this.avFuncionarios[indice].avaliacao_funcionario
            this.axios.get(this.route('admin.avaliados-listar', af))
                .then(({data}) => {
                    console.log(data)
                })
                .catch(err => {
                    console.log(err.response)
                })
        },
        tituloAba(titulo, data) {
            return `${titulo} - ${moment(data).format('MM/YYYY')}`
        }
    },
    watch: {
        abaAtiva(v) {
            if (!this.avaliados[v]) {
                this.listarAvaliados(v)
            }
        }
    }
}
</script>
