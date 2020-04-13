<template>
    <span>
        <div class="row mt-2">
            <div class="col-md-12">
                <h3>Avaliações</h3>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <datatable-flex
                    ref="tabelaAvaliacoes"
                    classe="table table-bordered table-striped"
                    :url="this.route('admin.avaliacao-datatable')"
                    ordem="1"
                    :btnCriar="false">

                    <span slot="botaoCriar">
                        <inertia-link :href="route('admin.avaliacao.create')">
                            <b-button variant="primary" size="sm"><i class="fas fa-plus-circle"></i> Cadastrar</b-button>
                        </inertia-link>
                    </span>

                        <span slot-scope="{ actions }">
                            <b-dropdown id="dropdown-left" size="sm" text="Ações" variant="primary" class="m-2">
                                <b-dropdown-item href="#" v-for="(action, index) in actions"
                                    :key="index"
                                    @click="acoesDataTable(action)"
                                >
                                <i :class="action.classe"></i>
                                {{ action.titulo }}
                                </b-dropdown-item>
                            </b-dropdown>
                        </span>

                        <span slot="perguntas" slot-scope="{ data }">
                            <b-badge variant="info">{{ data }}</b-badge>
                        </span>
                </datatable-flex>
            </div>
        </div>
    </span>
</template>

<script>
import moment from 'moment'
import Layout from '../../../Componentes/Layout'

export default {
    metaInfo: { title: 'Avaliação' },
    layout: Layout,
    data () {
        return {

        }
    },
    methods: {
        editarAvaliacao(id) {
            this.$inertia.visit(this.route('admin.avaliacao.show', id), { method: 'get' })
        },
        liberarAvaliacao(av) {
            this.$swal({
                text: 'Deseja mesmo liberar a avaliação para os funcionários?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.value) {
                    this.axios.get(this.route('admin.avaliacao-liberar', av))
                        .then(({data}) => {
                            this.$swal({
                                icon: 'success',
                                text: 'Avaliação liberada com sucesso'
                            })
                        })
                        .catch(err => {
                            let msg = 'Erro ao liberar a avaliação'
                            if (err.response.data.msg) {
                                msg = err.response.data.msg
                            }
                            this.$swal({
                                icon: 'error',
                                text: msg
                            })
                        })
                }
            })
        },
        acoesDataTable(value)
        {
            this[value.funcao](value.id);
        }
    },
    watch: {
        '$page.flash'() {
            if (this.$page.flash.success) {
                this.$refs.tabelaUsuarios.atualizar()
                this.$refs.modalUsuario.exibeModal = false
            }
        }
    }
}
</script>
