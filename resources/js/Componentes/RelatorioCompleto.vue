<template>
    <b-modal id="modalRelatorioCompleto" :title="tituloModal" v-model="exibeModal" :hide-footer="true" size="xl">
		<h2>Modal de Relatório</h2>
	</b-modal>
</template>

<script>
import moment from 'moment'
export default {
	data() {
		return {
			exibeModal: false,
			avFuncionario: {},
		}
	},
	methods: {
		gerarRelatorio() {
			this.axios.get(this.route('admin.relatorio-completo', 
					this.avFuncionario.avaliacao_funcionario))
                .then(({data}) => {
                    // this.avFuncionarios = data.avaliacoesFuncionarios
					// this.progresso = false
					console.log(data)
                })
                .catch(err => {
                    this.progresso = false
                    this.$swal({
                        icon: 'error',
                        text: err.response.data.msg
                    })
                })
		},
	},
	computed: {
		tituloModal() {
			if (this.avFuncionario.avaliacao_funcionario) {
				return `${this.avFuncionario.titulo_avaliacao} - ${moment(this.avFuncionario.periodo).format('MM/YYYY')}`
			}
			return 'Relatório Completo'
		}
	},
	watch: {
		exibeModal() {
			if (!this.exibeModal) {
				this.avFuncionario = {}
			}

			if (this.avFuncionario.avaliacao_funcionario) {
				this.gerarRelatorio()
			}
		}
	}
}
</script>