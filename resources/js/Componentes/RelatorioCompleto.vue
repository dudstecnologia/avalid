<template>
    <b-modal id="modalRelatorioCompleto" :title="tituloModal" v-model="exibeModal" :hide-footer="true" size="xl">
		
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Funcionário</th>
						<th v-for="(i, index) in baseTabela" :key="index">
							<div class="vertical-text">
								<div class="vertical-text__inner">
									{{ i }}
								</div>
							</div>
						</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(r, index) in resultadoCompleto" :key="index">
						<td>{{ r.nome }}</td>
						<td v-for="(n, i) in r.notas" :key="i">{{ n }}</td>
						<td>{{ r.total }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</b-modal>
</template>

<script>
import moment from 'moment'
export default {
	data() {
		return {
			exibeModal: false,
			avFuncionario: {},
			baseTabela: [],
			resultadoCompleto: [],
		}
	},
	methods: {
		gerarRelatorio() {
			this.axios.get(this.route('admin.relatorio-completo', 
					this.avFuncionario.avaliacao_funcionario))
                .then(({data}) => {
					this.criaBaseTabela(data.resultado[0].notas)
					this.resultadoCompleto = data.resultado
                })
                .catch(err => {
                    this.$swal({
                        icon: 'error',
                        text: err.response.data.msg
                    })
                })
		},
		criaBaseTabela(dados) {
			Object.keys(dados).forEach((key, indice) => {
				this.baseTabela.push(key)
			})
		}
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
				this.baseTabela = []
				this.resultadoCompleto = []
				this.gerarRelatorio()
			}
		}
	}
}
</script>

<style>
	.vertical-text {
		display: inline-block;
		overflow: hidden;
		width: 30px;
	}

	.vertical-text__inner {
		display: inline-block;
		white-space: nowrap;
		line-height: 1.5;
		transform: translate(0,100%) rotate(-90deg);
		transform-origin: 0 0;
	}

	.vertical-text__inner:after {
		content: "";
		display: block;
		margin: -1.5em 0 100%;
	}
</style>