<template>
    <div class="mt-3">
        <b-overlay :show="progresso">
            <b-card no-body>
                <b-tabs card v-model="abaAtiva">
                    <b-tab v-for="(a, index) in avFuncionarios" :key="a.avaliacao_funcionario" :title="tituloAba(a.titulo_avaliacao, a.periodo)">
                        <b-card-text>
                            <div>
                                <b-button v-if="a.status == 0" variant="primary" size="sm" @click="modalRelatorioCompleto()">Gerar Relatório</b-button>
                                <b-button v-if="a.status == 1" variant="danger" size="sm" @click="finalizarAvaliacao(a.avaliacao_funcionario, index)">Finalizar Avaliação</b-button>
                            </div>
                            <b-jumbotron class="mt-3 mjumbotron">
                                <div class="row">
                                    <div v-for="(u, i) in avaliados" :key="i" class="col-md-2">
                                        <div class="box-part text-center">
                                            <b-img :src="u.foto || '/padroes/avatar.png'" width="75" height="75" fluid rounded="circle"></b-img>
                                            <div class="box-text">
                                                <div class="text-truncate">{{ u.name }}</div>
                                            </div>
                                            <b-progress :max="avaliados.length - 1">
                                                <b-progress-bar :value="u.totalAvaliados" :label="`${((u.totalAvaliados / (avaliados.length - 1)) * 100)} %`"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                    </div>
                                </div>
                            </b-jumbotron>
                        </b-card-text>
                    </b-tab>
                </b-tabs>
                <p v-if="avFuncionarios.length == 0 && progresso == false" class="text-center">
                    Nenhuma avaliação encontrada
                </p>
            </b-card>
        </b-overlay>

        <relatorio-completo ref="modalRelatorioCompleto"></relatorio-completo>
    </div>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import RelatorioCompleto from '../../../Componentes/RelatorioCompleto'
import moment from 'moment'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    props: [
        'auth'
    ],
    components: {
        RelatorioCompleto
    },
    data () {
        return {
            progresso: true,
            abaAtiva: null,
            avFuncionarios: [],
            avaliacaoSelecionada: null,
            avaliados: [],
            autoRefresh: false,
            timer: null
        }
    },
    mounted() {
        this.listarAvaliacoes()
    },
    beforeDestroy () {
        this.pararAtualizador()
    },
    methods: {
        listarAvaliacoes() {
            this.axios.get(this.route('admin.avaliacao-funcionario-listar'))
                .then(({data}) => {
                    this.avFuncionarios = data.avaliacoesFuncionarios
                    this.progresso = false
                })
                .catch(err => {
                    this.progresso = false
                    this.$swal({
                        icon: 'error',
                        text: err.response.data.msg
                    })
                })
        },
        listarAvaliados() {
            let af = this.avFuncionarios[this.abaAtiva].avaliacao_funcionario
            this.axios.get(this.route('admin.avaliados-listar', af))
                .then(({data}) => {
                    this.avaliados = data.avaliados
                    this.progresso = false
                    if (this.avFuncionarios[this.abaAtiva].status) {
                        this.iniciarAtualizador()
                        this.verificaPendentesAvaliacao()
                    }
                })
                .catch(err => {
                    this.progresso = false
                    this.$swal({
                        icon: 'error',
                        text: err.response.data.msg
                    })
                })
        },
        verificaPendentesAvaliacao() {
            let pendenteAvaliacao = this.avaliados.find(a => a.totalAvaliados < (this.avaliados.length - 1))

            if (!pendenteAvaliacao) {
                this.pararAtualizador()
            }
        },
        finalizarAvaliacao(avfunc, index) {
            this.$swal({
                text: 'Deseja mesmo finalizar a avaliação?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.value) {
                    this.progresso = true
                    this.axios.get(this.route('admin.avaliacao-funcionario-finalizar', avfunc))
                        .then(({data}) => {
                            this.avFuncionarios[index].status = 0
                            this.pararAtualizador()
                            this.progresso = false
                            this.$swal({
                                icon: 'success',
                                text: data.msg
                            })
                        })
                        .catch(err => {
                            this.progresso = false
                            this.$swal({
                                icon: 'error',
                                text: err.response.data.msg
                            })
                        })            
                }
            })
        },
        modalRelatorioCompleto() {
            this.$refs.modalRelatorioCompleto.avFuncionario = this.avFuncionarios[this.abaAtiva]
            this.$refs.modalRelatorioCompleto.exibeModal = true
        },
        tituloAba(titulo, data) {
            return `${titulo} - ${moment(data).format('MM/YYYY')}`
        },
        iniciarAtualizador() {
            if (!this.timer) {
                console.log('Atualizador Iniciado')
                this.timer = setInterval( () => {
                    this.listarAvaliados()
                }, 5000)
            }
        },
        pararAtualizador() {
            if (this.timer) {
                console.log('Atualizador Finalizado')
                clearInterval(this.timer)
                this.timer = null
            }
        }
    },
    watch: {
        abaAtiva(v) {
            this.progresso = true
            this.pararAtualizador()
            this.listarAvaliados()
        }
    }
}
</script>
