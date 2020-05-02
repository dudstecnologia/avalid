<template>
    <b-jumbotron class="jumbotronQuestao">
        <div class="row">
            <div class="col-md-3">
                <b-form-select v-model="tipo" :options="tipos"></b-form-select>
            </div>
            <div class="col-md-3">
                <b-button variant="success" @click="addQuestao()">Adicionar Pergunta</b-button>
            </div>
        </div>

        <div v-for="(q, index) in questoes" :key="index" class="row mt-3">
            <div class="col-md-12">

                <b-card>
                    <div class="badge badge-secondary mb-2">
                        {{ q.tipo == 'multipla' ? 'Múltipla Escolha' : 'Dissertativa' }}
                    </div>

                    <b-form-input
                        class="mb-1"
                        v-model="q.titulo"
                        placeholder="Título da pergunta"
                        :state="q.titulo.length > 0"
                        :required="true">
                    </b-form-input>

                    <b-form-textarea
                        v-model="q.pergunta"
                        placeholder="Conteúdo da pergunta"
                        :state="q.pergunta.length > 0"
                        :required="true"
                        rows="2">
                    </b-form-textarea>

                    <div class="row mt-2">
                        <div class="col-md-6 align-middle">
                            <b-form-checkbox v-model="q.obrigatoria" name="check-button" switch>
                                Obrigatória
                            </b-form-checkbox>
                        </div>
                        <div class="col-md-6 text-right">
                            <b-button variant="danger" size="sm" @click="excluirQuestao(index)"><i class="fas fa-trash"></i></b-button>
                        </div>
                    </div>
                </b-card>
            </div>
        </div>
    </b-jumbotron>
</template>

<script>
export default {
    props: [
        'pQuestoes'
    ],
    data () {
        return {
            indice: 0,
            tipo: 'multipla',
            tipos: [
                { value: 'multipla', text: 'Múltipla Escolha' },
                { value: 'dissertativa', text: 'Dissertativa' },
            ],
            questoes: [],
            obrigatoria: [
                { text: 'Obrigatória', value: 1 }
            ]
        }
    },
    mounted() {
        this.setValoresIniciais()
    },
    methods: {
        addQuestao() {
            this.questoes.push({
                titulo: '',
                pergunta: '',
                tipo: this.tipo,
                obrigatoria: true
            })
        },
        excluirQuestao(index) {
            this.questoes.splice(index, 1)
        },
        setValoresIniciais() {
            if (this.pQuestoes) {
                this.questoes = this.pQuestoes.map(q => {
                    return {
                        id: q.id,
                        titulo: q.titulo,
                        pergunta: q.pergunta,
                        tipo: q.tipo,
                        obrigatoria: q.obrigatoria ? true : false
                    }
                })
            }
        }
    },
    watch: {
        questoes() {
            this.$emit('altera-questoes', this.questoes)
        }
    }
}
</script>

<style>
.jumbotronQuestao {
    padding: 10px;
}
</style>
