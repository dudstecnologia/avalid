<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-12">
                <h3>Formulário de Avaliação</h3>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <form @submit.prevent="salvar()">
                    <div class="row">
                        <div class="col-md-9">
                            <b-form-group label="Título" label-for="titulo">
                                <b-form-input id="titulo" type="text" v-model="form.titulo"
                                :state="$page.errors.titulo && $page.errors.titulo.lenght > 0" placeholder="Nome">
                                </b-form-input>
                                <b-form-invalid-feedback v-if="$page.errors.titulo"> {{ $page.errors.titulo[0] }} </b-form-invalid-feedback>
                            </b-form-group>
                        </div>

                        <div class="col-md-3">
                            <b-form-group label="Status" label-for="status">
                                <b-form-select v-model="form.status" :options="status" :state="$page.errors.status && $page.errors.status.lenght > 0"></b-form-select>
                                <b-form-invalid-feedback v-if="$page.errors.status"> {{ $page.errors.status[0] }} </b-form-invalid-feedback>
                            </b-form-group>
                        </div>
                    </div>

                    <div class="text-right">
                        <b-button type="submit" variant="primary">Salvar</b-button>
                        <b-button type="reset" variant="secondary">Cancelar</b-button>
                    </div>

                    <questao class="mt-2" @altera-questoes="alteraQuestoes" />
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import Questao from './Questao'

export default {
    metaInfo: { title: 'Formulário de Avaliação' },
    layout: Layout,
    components: {
        Questao
    },
    data() {
        return {
            // exibeModal: false,
            // type: [
            // 	{ value: 0, text: 'Funcionário' },
            // 	{ value: 1, text: 'Administrador' }
            // ],
            status: [
                { value: 1, text: 'Ativo' },
            	{ value: 0, text: 'Inativo' },
            ],
            form: {},
            // idUsuario: null,
        }
    },
    mounted() {
        this.limparForm()
    },
    methods: {
        salvar() {
            // if (this.idUsuario) {
            //     this.$inertia.put(this.route('admin.user.update', this.idUsuario), this.form)
            // } else {
                this.$inertia.post(this.route('admin.avaliacao.store'), this.form)
            // }
        },
        limparForm() {
            this.form =  {
                    titulo: '',
                    status: 1,
                    questoes: []
                }
        },
        alteraQuestoes(q) {
            console.log(q)
        }
        // getDadosUsuario() {
        // 	this.axios.get(this.route('admin.user.show', this.idUsuario))
        // 		.then(({data}) => {
        // 			this.form = data
        // 		})
        // 		.catch(err => {
        // 			this.$swal({
        // 				icon: 'error',
        // 				text: 'Erro ao buscar os dados do usuário'
        // 			})
        // 		})
        // }
    },
    // watch: {
    // 	exibeModal() {
    // 		if (!this.exibeModal) {
    // 			this.idUsuario = null
    // 			this.limparForm()
    // 		}
    // 		if (this.idUsuario) {
    // 			this.getDadosUsuario()
    // 		}
    // 	}
    // }
}
</script>