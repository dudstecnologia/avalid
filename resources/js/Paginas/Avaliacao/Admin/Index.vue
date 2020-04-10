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
                    @create="formCadastro()">

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

                        <span slot="status" slot-scope="{ data }">
                            <b-badge :variant="data == 'Ativa' ? 'success' : 'danger'">{{ data }}</b-badge>
                        </span>

                </datatable-flex>
            </div>
        </div>

        <!-- <form-usuario ref="modalUsuario"></form-usuario> -->
    </span>
</template>

<script>
import Layout from '../../../Componentes/Layout'

export default {
    metaInfo: { title: 'Usuários' },
    layout: Layout,
    components: {
        // Paginacao,
        // FormUsuario
    },
    props: {
        users: Object,
    },
    data () {
        return {

        }
    },
    methods: {
        editarAvaliacao(id) {
            console.log(id)
            this.$inertia.visit(this.route('admin.avaliacao.show', id), {
                method: 'get'
            })
            // this.$refs.modalUsuario.idUsuario = id
            // this.$refs.modalUsuario.exibeModal = true
        },
        alterarStatus(user)
        {
            this.$swal({
                text: "Deseja mesmo alterar o status?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.value) {
                    this.axios.get(this.route('admin.user-alterarstatus', user))
                        .then(({data}) => {
                            this.$refs.tabelaUsuarios.atualizar()
                            this.$swal({
                                icon: 'success',
                                text: 'Status alterado com sucesso'
                            })
                        })
                        .catch(err => {
                            this.$swal({
                                icon: 'error',
                                text: 'Erro ao alterar o status do usuário'
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
