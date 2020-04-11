<template>
    <b-modal id="modalAvaliacao" :title="tituloModal" v-model="exibeModal" :hide-footer="true" size="xl">
		<form class="formAvaliacao" @submit.prevent="salvar()">
            <div v-for="(q, index) in questoes" :key="index" class="row mt-3">
                <div class="col-md-12">
                    <b-card>
                        <p>{{ q.pergunta }}<span v-if="q.obrigatoria" class="text-danger">*</span></p>

                        <b-form-group class="text-center" v-if="q.tipo == 'multipla'">
                            <b-form-radio-group v-model="form[q.id]" :name="'multi' + q.id" :required="q.obrigatoria ? true : false">
                                <b-form-radio v-for="n in q.range.final" :key="n" :value="n">{{ n }}</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                        <b-form-textarea v-if="q.tipo == 'disertativa'"
                            v-model="form[q.id]"
                            placeholder="..."
                            :required="q.obrigatoria ? true : false"
                            rows="2">
                        </b-form-textarea>
                    </b-card>
                </div>
            </div>
			<div class="text-right mt-3">
				<b-button type="submit" variant="primary">Salvar</b-button>
				<b-button type="reset" variant="secondary" @click="$bvModal.hide('modalAvaliacao')">Cancelar</b-button>
			</div>
		</form>
	</b-modal>
</template>

<script>
	export default {
        props: [
            'avaliacaoPeriodo',
            'avaliacao',
            'questoes'
        ],
		data() {
			return {
				exibeModal: false,
				form: {},
				avaliado: null,
			}
		},
		mounted() {
			// this.limparForm()
		},
		methods: {
			salvar() {
				this.$inertia.post(this.route('funcionario.avaliacao-store'), this.form)
			},
			// limparForm() {
			// 	this.form =  {
			// 			name: '',
			// 			email: '',
			// 			password: '',
			// 			password_confirmation: '',
			// 			admin: 0,
			// 			status: 0,
			// 		}
			// },
			getDadosUsuario() {
				this.axios.get(this.route('admin.user.show', this.idUsuario))
					.then(({data}) => {
						this.form = data
					})
					.catch(err => {
						this.$swal({
							icon: 'error',
							text: 'Erro ao buscar os dados do usuário'
						})
					})
			}
        },
        computed: {
            tituloModal() {
                if (this.avaliado && this.avaliacao) {
                    return `${this.avaliacao.titulo} - ${this.avaliado.name}`
                }

                return 'Avaliação'
            }
        },
		watch: {
			exibeModal() {
				if (!this.exibeModal) {
					this.idUsuario = null
					this.form = {}
				}
				// if (this.idUsuario) {
				// 	this.getDadosUsuario()
				// }
			}
		}
	}
</script>

<style>
.modal-body {
    background-color: #e9ecef;
}
.card-body {
    padding: 5px;
}
</style>