<template>
    <span>
        <div class="row mt-2">
            <div class="col-md-12">
                <h3>Usuários</h3>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <datatable-flex
                    ref="tabelaUsuarios"
                    classe="table table-bordered table-striped"
                    :url="this.route('admin.user-datatable')"
                    ordem="1"
                    @create="modalUsuario()">

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

                        <span slot="admin" slot-scope="{ data }">
                            <b-badge :variant="data == 'Administrador' ? 'info' : 'secondary'">{{ data }}</b-badge>
                        </span>

                        <span slot="status" slot-scope="{ data }">
                            <b-badge :variant="data == 'Ativo' ? 'success' : 'danger'">{{ data }}</b-badge>
                        </span>

                </datatable-flex>
            </div>
        </div>

        <form-usuario ref="modalUsuario"></form-usuario>
    </span>
</template>

<script>
import Layout from '../../Componentes/Layout'
import Paginacao from '../../Componentes/Paginacao'
import FormUsuario from './Form'

export default {
    metaInfo: { title: 'Usuários' },
    layout: Layout,
    components: {
        Paginacao,
        FormUsuario
    },
    props: {
        users: Object,
    },
    data () {
        return {

        }
    },
    methods: {
        modalUsuario(id = null) {
            this.$refs.modalUsuario.idUsuario = id
            this.$refs.modalUsuario.exibeModal = true
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
            console.log('Vai alterar o status')
            // this.$root.iziQuestion()
            //     .then(sim => {
            //         this.$http.get(this.$routes.route("restrito.alterar.status.setor", { setor }))
            //         .then(response => {
            //             this.$refs.tabelaSetores.atualizar();
            //             this.$toast.success(response.data.msg || 'Status alterado com sucesso', "Sucesso!", this.$root.config.success);
            //         })
            //     })
            //     .catch(nao => {})
        },
        acoesDataTable(value)
        {
            this[value.funcao](value.id);
        }
    },
    watch: {
        '$page.flash.success'() {
            this.$refs.tabelaUsuarios.atualizar()
            this.$refs.modalUsuario.exibeModal = false
        }
    }
}
</script>
