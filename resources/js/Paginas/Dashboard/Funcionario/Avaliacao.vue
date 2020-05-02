<template>
    <b-modal id="modalAvaliacao" :title="tituloModal" v-model="exibeModal" :hide-footer="true" size="xl">
        <span class="text-danger">* Obrigatório</span>
		<form class="formAvaliacao" @submit.prevent="salvar()">
            <div v-for="(q, index) in questoes" :key="index" class="row mt-3">
                <div class="col-md-12">
                    <b-card>
                        <p class="mb-1">
                            <strong>
                                {{ index + 1 }}. {{ q.titulo }} <span v-if="q.obrigatoria" class="text-danger"> *</span>
                            </strong>
                        </p>

                        <p>{{ q.pergunta }}</p>

                        <b-form-group class="text-center" v-if="q.tipo == 'multipla'">
                            <b-form-radio-group v-model="form[q.id]" :name="'multi' + q.id" :required="q.obrigatoria ? true : false">
                                <b-form-radio v-for="n in 10" :key="n" :value="n">{{ n }}</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                        <b-form-textarea v-if="q.tipo == 'dissertativa'"
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
            'avaliacaoFuncionario',
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
		methods: {
			salvar() {
                this.form.avaliacaoFuncionario = this.avaliacaoFuncionario.id
                this.form.avaliado = this.avaliado.id
				this.$inertia.post(this.route('funcionario.avaliacao-store'), this.form)
			},
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
					this.form = {}
				}
			}
		}
	}
</script>

<style>
.modal-body {
    background-color: #e9ecef;
}
.card-body {
    padding: 10px;
}
</style>
