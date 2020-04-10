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
                                <b-form-input id="titulo" type="text" v-model="form.titulo" :required="true"
                                :state="$page.errors.titulo && $page.errors.titulo.lenght > 0" placeholder="Título">
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
                        <inertia-link :href="route('admin.avaliacao.index')">
                            <b-button variant="secondary">Voltar</b-button>
                        </inertia-link>
                    </div>

                    <questao :pQuestoes="questoes" class="mt-2" @altera-questoes="alteraQuestoes" />

                    <div v-if="form.questoes && form.questoes.length > 1" class="text-right mb-3">
                        <b-button type="submit" variant="primary">Salvar</b-button>
                    </div>
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
    props: [
        'avaliacao',
        'questoes'
    ],
    data() {
        return {
            status: [
                { value: 1, text: 'Ativa' },
            	{ value: 0, text: 'Inativa' },
            ],
            form: {},
            idAvaliacao: this.avaliacao ? this.avaliacao.id : null,
        }
    },
    mounted() {
        this.limparForm()
        if (this.avaliacao) {
            this.form = this.avaliacao
        }
    },
    methods: {
        salvar() {
            if (this.form.questoes.length > 0) {
                if (this.idAvaliacao) {
                    this.$inertia.put(this.route('admin.avaliacao.update', this.idAvaliacao), this.form)
                } else {
                    this.$inertia.post(this.route('admin.avaliacao.store'), this.form)
                }
            } else {
                this.$swal({
                    icon: 'error',
                    text: 'Pelo menos uma pergunta deve ser inserida'
                })
            }
        },
        limparForm() {
            this.form =  {
                    titulo: '',
                    status: 1,
                    questoes: []
                }
        },
        alteraQuestoes(q) {
            this.form.questoes = q
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
    }
}
</script>