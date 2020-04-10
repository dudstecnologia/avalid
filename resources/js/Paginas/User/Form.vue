<template>
	<b-modal id="modalUsuario" title="Formulário de Usuário" v-model="exibeModal" :hide-footer="true">
		<form @submit.prevent="salvar()">
			<b-form-group label="Nome" label-for="nome">
				<b-form-input id="nome" type="text" v-model="form.name"
				:state="$page.errors.name && $page.errors.name.lenght > 0" placeholder="Nome">
				</b-form-input>
				<b-form-invalid-feedback v-if="$page.errors.name"> {{ $page.errors.name[0] }} </b-form-invalid-feedback>
			</b-form-group>

			<b-form-group label="Email" label-for="email">
				<b-form-input id="email" type="text" v-model="form.email"
				:state="$page.errors.email && $page.errors.email.lenght > 0" placeholder="Email">
				</b-form-input>
				<b-form-invalid-feedback v-if="$page.errors.email"> {{ $page.errors.email[0] }} </b-form-invalid-feedback>
			</b-form-group>

			<div class="row">
				<div class="col-md-6">
					<b-form-group label="Senha" label-for="password">
						<b-form-input id="password" type="password" v-model="form.password"
						:state="$page.errors.password && $page.errors.password.lenght > 0" placeholder="Email">
						</b-form-input>
						<b-form-invalid-feedback v-if="$page.errors.password"> {{ $page.errors.password[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>

				<div class="col-md-6">
					<b-form-group label="Confirmar Senha" label-for="password_confirmation">
						<b-form-input id="password_confirmation" type="password" v-model="form.password_confirmation"
						:state="$page.errors.password_confirmation && $page.errors.password_confirmation.lenght > 0" placeholder="Email">
						</b-form-input>
						<b-form-invalid-feedback v-if="$page.errors.password_confirmation"> {{ $page.errors.password_confirmation[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<b-form-group label="Tipo" label-for="admin">
						<b-form-select v-model="form.admin" :options="type" :state="$page.errors.admin && $page.errors.admin.lenght > 0"></b-form-select>
						<b-form-invalid-feedback v-if="$page.errors.admin"> {{ $page.errors.admin[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>

				<div class="col-md-6">
					<b-form-group label="Status" label-for="status">
						<b-form-select v-model="form.status" :options="status" :state="$page.errors.status && $page.errors.status.lenght > 0"></b-form-select>
						<b-form-invalid-feedback v-if="$page.errors.status"> {{ $page.errors.status[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>
			</div>

			<div class="text-right">
				<b-button type="submit" variant="primary">Salvar</b-button>
				<b-button type="reset" variant="secondary" @click="$bvModal.hide('modalUsuario')">Cancelar</b-button>
			</div>
		</form>
	</b-modal>
</template>

<script>
	export default {
		data() {
			return {
				exibeModal: false,
				type: [
					{ value: 0, text: 'Funcionário' },
					{ value: 1, text: 'Administrador' }
				],
				status: [
					{ value: 0, text: 'Inativo' },
					{ value: 1, text: 'Ativo' }
				],
				form: {},
				idUsuario: null,
			}
		},
		mounted() {
			this.limparForm()
		},
		methods: {
			salvar() {
				if (this.idUsuario) {
					this.$inertia.put(this.route('admin.user.update', this.idUsuario), this.form)
				} else {
					this.$inertia.post(this.route('admin.user.store'), this.form)
				}
			},
			limparForm() {
				this.form =  {
						name: '',
						email: '',
						password: '',
						password_confirmation: '',
						admin: 0,
						status: 0,
					}
			},
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
		watch: {
			exibeModal() {
				if (!this.exibeModal) {
					this.idUsuario = null
					this.limparForm()
				}
				if (this.idUsuario) {
					this.getDadosUsuario()
				}
			}
		}
	}
</script>