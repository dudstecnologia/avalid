<template>
    <span>
        <div class="row mt-2">
            <div class="col-md-12">
                <h3>Perfil</h3>
            </div>
        </div>

<div class="row">
    <div class="col-sm-3">
        <img :src="foto ? foto : '/padroes/avatar.png'" class="avatar img-circle img-thumbnail" @click="exibeModalFoto = !exibeModalFoto" alt="avatar">
    </div>

    <div class="col-sm-9">
        <form @submit.prevent="salvar()">
			<b-form-group label="Nome" label-for="nome">
				<b-form-input id="nome" type="text" v-model="form.name"
				:state="$page.errors.name && $page.errors.name.lenght > 0" placeholder="Nome">
				</b-form-input>
				<b-form-invalid-feedback v-if="$page.errors.name"> {{ $page.errors.name[0] }} </b-form-invalid-feedback>
			</b-form-group>

            <b-form-group label="Email" label-for="email">
				<b-form-input id="email" type="text" v-model="email" placeholder="Email" readonly>
				</b-form-input>
			</b-form-group>

			<div class="row">
				<div class="col-md-6">
					<b-form-group label="Senha" label-for="password">
						<b-form-input id="password" type="password" v-model="form.password"
						:state="$page.errors.password && $page.errors.password.lenght > 0" placeholder="Senha">
						</b-form-input>
						<b-form-invalid-feedback v-if="$page.errors.password"> {{ $page.errors.password[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>

				<div class="col-md-6">
					<b-form-group label="Confirmar Senha" label-for="password_confirmation">
						<b-form-input id="password_confirmation" type="password" v-model="form.password_confirmation"
						:state="$page.errors.password_confirmation && $page.errors.password_confirmation.lenght > 0" placeholder="Confirmar Senha">
						</b-form-input>
						<b-form-invalid-feedback v-if="$page.errors.password_confirmation"> {{ $page.errors.password_confirmation[0] }} </b-form-invalid-feedback>
					</b-form-group>
				</div>
			</div>

			<div class="text-right">
				<b-button type="submit" variant="primary">Salvar</b-button>
				<inertia-link :href="route('dashboard')">
                        <b-button variant="secondary">Voltar</b-button>
                </inertia-link>
			</div>
		</form>
    </div>
</div>

    <b-modal id="modalFoto" title="Foto do perfil" v-model="exibeModalFoto" :hide-footer="true">
        <b-overlay :show="carregandoImagem" rounded="sm">
            <b-form-file
                @change="selecionaFoto($event)"
                v-model="imagemSelecionada"
                :state="Boolean(imagemSelecionada)"
                placeholder="Selecione a imagem"
                drop-placeholder="Selecione a imagem"
                accept="image/*"
                size="sm">
            </b-form-file>

            <cropper
                v-if="imagemBase64"
                classname="cropper mt-2"
                :src="imagemBase64"
                :stencilProps="{
                aspectRatio: 1/1
                }"
                @change="editFoto"
                @ready="imagemCarregada">
            </cropper>

            <div class="text-center">
                <b-button class="mt-2" v-if="btnSalvar" variant="primary" @click="salvarFoto()" size="sm">Recortar e Salvar</b-button>
            </div>
        </b-overlay>
    </b-modal>
        
    </span>
</template>

<script>
import Layout from '../../../Componentes/Layout'
import { Cropper } from 'vue-advanced-cropper'

export default {
    metaInfo: { title: 'Usuários' },
    layout: Layout,
    props: [
        'user'
    ],
    components: {
        Cropper
    },
    data () {
        return {
            exibeModalFoto: false,
            imagemSelecionada: null,
            imagemBase64: null,
            imagemRecortada: null,
            carregandoImagem: false,
            btnSalvar: null,
            form: {
                name: null,
                foto: null,
            },
            email: '',
            foto: '',
        }
    },
    mounted() {
        this.form.name = this.user.name
        this.foto = this.user.foto
        this.email = this.user.email
    },
    methods: {
        salvar() {
            this.$inertia.post(this.route('funcionario.user.store'), this.form)
        },
        selecionaFoto(event) {
            if (event.target.files[0]) {
                this.carregandoImagem = true
                var file = event.target.files[0],
                reader = new FileReader();

                reader.onloadend = () => {
                    this.imagemBase64 = reader.result
                }

                reader.readAsDataURL(file);
            }
        },
        editFoto({coordinates, canvas}) {
            this.imagemRecortada = canvas.toDataURL()
        },
        imagemCarregada() {
            this.btnSalvar = true
            this.carregandoImagem = false
        },
        salvarFoto() {
            this.form.foto = this.imagemRecortada
            this.foto = this.imagemRecortada
            this.exibeModalFoto = false
        }
    },
    watch: {
        exibeModalFoto() {
            if (!this.exibeModalFoto) {
                this.imagemSelecionada = null
                this.imagemBase64 = null
                this.imagemRecortada = null
                this.btnSalvar = null
            }
        }
    }
}
</script>
