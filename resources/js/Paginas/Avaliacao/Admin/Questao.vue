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
                        {{ q.tipo == 'multipla' ? 'Múltipla Escolha' : 'Disertativa' }}
                    </div>

                    <b-form-textarea
                        v-model="q.pergunta"
                        placeholder="Título da pergunta"
                        :state="q.pergunta.length > 0"
                        :required="true"
                        rows="2">
                    </b-form-textarea>

                    <div class="row mt-2">
                        <div class="col-md-3 align-middle">
                            <b-form-checkbox v-model="q.obrigatoria" name="check-button" switch>
                                Obrigatória
                            </b-form-checkbox>
                        </div>
                        <div class="col-md-6 text-center">
                            <span v-if="q.tipo == 'multipla'">
                                <label for="sb-inline">De</label>
                                <b-form-spinbutton id="sb-inline" v-model="q.range.inicio" inline></b-form-spinbutton>
                                <label for="sb-inline">até</label>
                                <b-form-spinbutton id="sb-inline" v-model="q.range.final" inline></b-form-spinbutton>
                            </span>
                        </div>
                        <div class="col-md-3 text-right">
                            <b-button variant="danger" size="sm"><i class="fas fa-trash"></i></b-button>
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
                { value: 'disertativa', text: 'Disertativa' },
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
                pergunta: '',
                tipo: this.tipo,
                range: {
                    inicio: 1,
                    final: 10
                },
                obrigatoria: true
            })
        },
        setValoresIniciais() {
            if (this.pQuestoes) {
                this.questoes = this.pQuestoes.map(q => {
                    return {
                        id: q.id,
                        pergunta: q.pergunta,
                        tipo: q.tipo,
                        range: q.range,
                        obrigatoria: q.obrigatoria ? true : false
                    }
                })
            }
        }
    },
    watch: {
        // questoes: {
        //     handler:function(newVal) {
        //         this.$emit('altera-questoes', this.questoes)
        //     }
        // }
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