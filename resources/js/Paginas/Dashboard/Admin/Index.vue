<template>
    <div class="mt-3">
        <b-overlay :show="progresso">
            <b-card no-body>
                <b-tabs card v-model="abaAtiva">
                    <b-tab v-for="a in avFuncionarios" :key="a.avaliacao_funcionario" :title="tituloAba(a.titulo_avaliacao, a.periodo)">
                        <b-card-text>
                            <div>
                                <b-button variant="primary" size="sm">Gerar Relatório</b-button>
                                <b-button v-if="a.status == 1" variant="danger" size="sm">Finalizar Avaliação</b-button>
                                <b-form-checkbox v-model="autoRefresh" name="check-button" switch>
                                    Monitorar
                                </b-form-checkbox>
                            </div>

                            <b-jumbotron class="mt-3 mjumbotron">
                                <div class="row">
                                    <div v-for="(u, i) in avaliados" :key="i" class="col-md-2">
                                        <div class="box-part text-center">
                                            <b-img :src="u.foto || '/padroes/avatar2.png'" width="75" height="75" fluid rounded="circle"></b-img>
                                            <div class="box-text">
                                                <div class="text-truncate">{{ u.name }}</div>
                                            </div>
                                            <!-- <b-progress variant="primary" :value="u.totalAvaliados" :max="avaliados.length - 1" show-progress></b-progress> -->
                                            <!-- <b-progress :max="avaliados.length - 1">
                                                <b-progress-bar :value="u.totalAvaliados" :label="`${((u.totalAvaliados / (avaliados.length - 1)) * 100)} %`"></b-progress-bar>
                                            </b-progress> -->
                                            <b-progress :max="avaliados.length - 1">
                                                <b-progress-bar :value="u.totalAvaliados">
                                                    <strong>{{ u.totalAvaliados }} / {{ (avaliados.length - 1) }}</strong>
                                                </b-progress-bar>
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
                    console.log(data)
                    this.avaliados = data.avaliados
                    this.progresso = false
                    this.iniciarAtualizador()
                })
                .catch(err => {
                    this.progresso = false
                    this.$swal({
                        icon: 'error',
                        text: err.response.data.msg
                    })
                })
        },
        tituloAba(titulo, data) {
            return `${titulo} - ${moment(data).format('MM/YYYY')}`
        },
        iniciarAtualizador() {
            if (!this.timer) {
                this.timer = setInterval( () => {
                    this.listarAvaliados()
                }, 7000)
            }
        },
        pararAtualizador() {
            if (this.timer) {
                clearInterval(this.timer)
            }
        }
    },
    watch: {
        abaAtiva(v) {
            this.progresso = true
            this.listarAvaliados()
        }
    }
}
</script>
