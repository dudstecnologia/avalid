<template>
<span>
    <b-jumbotron v-if="avaliacao" class="mt-3 mjumbotron">
        <div class="row">
            <div v-for="(a, index) in avaliados" :key="index" class="col-md-2">
                <div class="box-part text-center">
                    <b-img :src="a.foto || '/img/avatar2.png'" width="75" height="75" fluid rounded="circle"></b-img>
                    <div class="text">
                        <div class="text-truncate">{{ a.name }}</div>
                    </div>
                    <i v-if="a.avaliado" class="fas fa-check-double"></i>
                    <b-button v-else variant="primary" size="sm" @click="abrirAvaliacao(a)">Avaliar</b-button>
				</div>
            </div>
        </div>
    </b-jumbotron>
    <div v-else class="mt-5">
        <b-overlay :show="buscando" rounded="sm">
            <h4 class="text-center"> </h4>
        </b-overlay>
    </div>
    <form-avaliacao ref="modalAvaliacao" :avaliacaoFuncionario="avaliacaoFuncionario" :avaliacao="avaliacao" :questoes="questoes"></form-avaliacao>
</span>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import FormAvaliacao from './Avaliacao'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
    props: [
        'auth',
        // 'flash'
    ],
    components: {
        FormAvaliacao
    },
    data () {
        return {
            avaliacaoFuncionario: null,
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
                    this.avaliacaoFuncionario = data.avaliacaoFuncionario
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
    },
    watch: {
        '$page.flash'() {
            if (this.$page.flash.message) {
                this.$refs.modalAvaliacao.avaliado = null
                this.$refs.modalAvaliacao.exibeModal = false
                this.avaliados = this.avaliados.map(a => {
                    if (a.id == this.$page.flash.message.avaliado) {
                        return {
                            email: a.email,
                            foto: a.foto,
                            id: a.id,
                            name: a.name,
                            avaliado: true
                        }
                    }
                    return a
                })
            }
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