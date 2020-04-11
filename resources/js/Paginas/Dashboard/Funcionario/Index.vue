<template>
<span>
    <b-jumbotron v-if="avaliacao" class="mt-3 mjumbotron">
        <div class="row">
            <div v-for="(a, index) in avaliados" :key="index" class="col-md-2">
                <div class="box-part text-center">
                    <b-img :src="a.foto || '/img/avatar.png'" width="75" height="75" fluid rounded="circle"></b-img>
                    <div class="text">
                        <div class="text-truncate">{{ a.name }}</div>
                    </div>
                    <b-button variant="primary" size="sm" @click="abrirAvaliacao(a)">Avaliar</b-button>
				</div>
            </div>
        </div>
    </b-jumbotron>
    <div v-else class="mt-5">
        <b-overlay :show="buscando" rounded="sm">
            <h4 class="text-center"> </h4>
        </b-overlay>
    </div>
    <form-avaliacao ref="modalAvaliacao" :avaliacaoPeriodo="avaliacaoPeriodo" :avaliacao="avaliacao" :questoes="questoes"></form-avaliacao>
</span>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import FormAvaliacao from './Avaliacao'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    props: [
        'auth'
    ],
    components: {
        FormAvaliacao
    },
    data () {
        return {
            avaliacaoPeriodo: null,
            avaliacao: null,
            questoes: null,
            buscando: true,
            avaliados: []
        }
    },
    mounted() {
        this.verificaAvaliacao()
    },
    methods: {
        verificaAvaliacao() {
            this.axios.get(this.route('funcionario.verifica-avaliacao'))
                .then(({data}) => {
                    this.buscando = false
                    this.avaliacaoPeriodo = data.avaliacaoPeriodo
                    this.avaliacao = data.avaliacao
                    this.questoes = data.questoes
                    this.listarAvaliados()
                })
                .catch(err => {
                    this.buscando = false
                    if (err.response.data) {
                        this.$swal({
                            icon: 'error',
                            text: err.response.data.msg
                        })
                    }
                })
        },
        listarAvaliados() {
            this.axios.get(this.route('funcionario.lista-avaliados'))
                .then(({data}) => {
                    this.avaliados = data.avaliados
                })
                .catch(err => {
                    this.buscando = false
                    if (err.response.data) {
                        this.$swal({
                            icon: 'error',
                            text: err.response.data.msg
                        })
                    }
                })
        },
        abrirAvaliacao(avaliado) {
            this.$refs.modalAvaliacao.avaliado = avaliado
            this.$refs.modalAvaliacao.exibeModal = true
        }
    }
}
</script>

<style>
.mjumbotron {
    padding: 10px;
}

.box-part{
    background: #FFF;
    border-radius: 0;
    padding: 10px 10px;
}

.text {
    margin: 10px 0px;
}

.fa{
     color:#4183D7;
}
</style>