<template>
    <div>
        <div class="row">
            <div class="col-sm-7 col-md-9">
                <div class="mb-2">
                    <slot name="botaoCriar">
                        <b-button v-if="btnCriar" @click="create()" variant="primary" size="sm"><i class="fas fa-plus-circle"></i> Cadastrar</b-button>
                    </slot>
                    
                    <b-dropdown v-if="btnExportar" variant="primary" size="sm">
                        <template v-slot:button-content>
                            <i class="fas fa-download"></i> Exportar
                        </template>
                        <b-dropdown-item @click="exportar('excel')"><i class="far fa-file-excel"></i> Excel</b-dropdown-item>
                        <b-dropdown-item @click="exportar('pdf')"><i class="far fa-file-pdf"></i> PDF</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>
            <div class="col-sm-5 col-md-3">
                <div class="mb-2">
                    <input type="search" class="form-control form-control-sm" placeholder="Pesquisar" v-model="search">
                </div>
            </div>
        </div>

        <div class="table-responsive mb-2">
            <table v-if="colunas.length > 0" :class="classe">
                <thead>
                    <tr>
                        <th v-for="(col, index) in colunas" :key="index" :width="col.width" nowrap><span>{{ col['title'] }}</span> <a v-if="col.orderable" @click="ordernar(index)" class="fas fa-sort float-right filtro"></a></th>
                    </tr>
                </thead>
                <tbody v-if="linhas">
                    <tr v-for="(linha, index) in linhas" :key="index">
                        <td class="align-middle td-datatable" v-for="(col, index) in colunas" :key="index" nowrap>
                            <span v-if="col.data == 'action'">
                                <slot :actions="linha[col.data]"></slot>
                            </span>
                            <span v-else>
                                <slot :name="col.data" :linha="linha" :data="linha[col.data]">
                                    <span v-html="linha[col.data]"></span>
                                </slot>
                            </span>
                        </td>
                    </tr>
                    <tr v-if="linhas.length == 0">
                        <td class="text-center" :colspan="colunas.length" nowrap>Nenhum registro encontrado</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div>
                    {{ statusContagem }}
                </div>
            </div>
            <div class="col-md-12">
                <b-pagination
                    v-model="paginaAtual"
                    :total-rows="recordsFiltered"
                    :per-page="length"
                    prev-text="Anterior"
                    next-text="Próximo"
                    size="sm"
                    align="right">
                </b-pagination>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    /** EXEMPLO DE USO
     *
     *   <datatable-flex
     *      ref="tabelaNome"                                // Referencia da tabela (no momento é usada apenas para reload)
     *      classe="table table-bordered table-striped"     // Classes para adicionar no elemento table, no padrão vem 'table table-bordered table-striped'
     *      :filtros="meusFiltros"                          // (Opcional) Filtros personalizados (Devem ser passados como Objeto)
     *      :url="this.$routes.route('sua.rota')"           // Rota a qual o datatable vai pegar os dados
     *      :btnCriar="false"                               // (Opcional) Deixa oculto o botão de criar, por padrão é visível
     *      :btnExportar="false"                            // (Opcional) Deixa oculto o botão de exportar, por padrão é visível
     *      ordem="1"                                       // (Opcional) Define qual coluna vai ser utilizada para ordenação, por padrão é a coluna 1
     *      @create="funcaoParaCadastro">
     *
     *          <span slot-scope="{ actions }">             // (Opcional) Slot para você personalizar as ações de cada linha do datatable
     *          </span>
     *
     *          <span slot="nome_coluna" slot-scope="{ data }">     // (Opcional) Slot para você personalizar qualquer coluna que se faça necessário 
     *          </span>                                             // O que estiver aqui dentro, vai modificar o conteúdo na célula específica
     *                                                              // Exemplo Quando você precisar colocar um label na coluna status...
     *          
     *   </datatable-flex>
     *
     *
     *   this.$refs.tabelaNome.atualizar()                  // função para atualização do datatable
     */
    props: {
        classe : {
            type: String,
            default: 'table table-bordered table-striped'
        },
        btnCriar: {
            type: Boolean,
            default: true
        },
        btnExportar: {
            type: Boolean,
            default: true
        },
        ordem: {
            type: String,
            default: '1'
        },
        url: {
            type: String,
            default: ''
        },
        filtros: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    data () {
        return {
            colunas: [],
            linhas: [],
            urlDatatable: '',
            draw: 1,
            start: 0,
            length: 10,
            recordsFiltered: 0,
            recordsTotal: 0,
            search: '',
            paginaAtual: 1,
            order: {
                column: this.ordem,
                dir: 'asc'
            }
        }
    },
    watch: {
        search (v) {
            this.start = 0
            this.montaUrl()
        },
        paginaAtual (v) {
            this.start = (v - 1) * this.length
            this.montaUrl()
        }
    },
    computed: {
        statusContagem () {
            let c = []
            if (this.recordsFiltered == 0 || this.recordsTotal == 0) {
                c = [0, 0, 0]
            } else if (this.recordsFiltered == this.recordsTotal) {
                c = [
                        this.start + 1,
                        (this.start + 1 >= this.recordsTotal ? this.linhas.length : this.start + this.linhas.length),
                        this.recordsTotal
                    ]
            } else {
                c = [
                        this.start + 1,
                        (this.start + 1 >= this.recordsTotal ? this.linhas.length : this.start + this.linhas.length),
                        this.recordsFiltered,
                        `(Filtrados de ${this.recordsTotal} registros)`
                    ]
            }

            return `Mostrando de ${c[0]} até ${c[1]} de ${c[2]} registros ${c[3] || ''}`
        }
    },
    mounted () {
        this.getColunas()
    },
    methods: {
        requisicao () {
            // this.$insProgress.start()
            this.axios.get(this.urlDatatable)
                .then(res => {
                    // this.$insProgress.finish()
                    this.linhas = res.data.data
                    this.recordsFiltered = res.data.recordsFiltered
                    this.recordsTotal = res.data.recordsTotal

                    if (res.data.error) alert(res.data.error)
                })
                .catch(err => {
                    // this.$insProgress.finish()
                    alert(err)
                })
        },
        create () {
            this.$emit('create')
        },
        ordernar (i) {
            this.order.column = i
            this.order.dir == 'asc' ? this.order.dir = 'desc' : this.order.dir = 'asc'
            this.start = 0
            this.montaUrl()
        },
        exportar (extend) {
            this.montaUrl(extend)
        },
        atualizar () {
            this.montaUrl()
        },
        montaUrl (action = null) {
            var time = new Date().getTime();
            let urlTemp = `${this.url}?draw=${this.draw++}`

            for (let i = 0; i < this.colunas.length; i++) {
                let c = this.colunas[i]
                urlTemp += `&columns[${i}][data]=${c.data}&columns[${i}][name]=${c.name}&columns[${i}][searchable]=${c.searchable}&columns[${i}][orderable]=${c.orderable}&columns[${i}][search][value]=&columns[${i}][search][regex]=false`
            }

            let ft = '';
            Object.entries(this.filtros).forEach(([key, value]) => {
                ft += `${key}=${value}&`
            })

            if (action) {
                if (ft.length > 0) ft = `&${ft.substring(0, ft.length - 1)}`
                urlTemp += `&order[0][column]=${this.order.column}&order[0][dir]=${this.order.dir}&start=${this.start}&length=${this.length}&search[value]=${this.search}&search[regex]=false&action=${action}${ft}`
                this.urlDatatable = encodeURI(urlTemp)
                this.download(action)
            } else {
                urlTemp += `&order[0][column]=${this.order.column}&order[0][dir]=${this.order.dir}&start=${this.start}&length=${this.length}&search[value]=${this.search}&search[regex]=false&${ft}_=${time}`
                this.urlDatatable = encodeURI(urlTemp)
                this.requisicao()
            }
        },
        download(type) {
            // this.$insProgress.start()
            this.axios({ url: this.urlDatatable, method: 'GET',responseType: 'blob'})
                .then((res) => {
                    // this.$insProgress.finish()

                    const url = window.URL.createObjectURL(new Blob([res.data]))
                    const link = document.createElement('a')
                    link.href = url

                    let h = res.headers['content-disposition']
                    let arquivo = h.substring(h.indexOf('filename=') + 9).split('"').join('')

                    link.setAttribute('download', arquivo)
                    document.body.appendChild(link)
                    link.click()
                })
                .catch((err) => {
                    // this.$insProgress.finish()
                    alert(err) 
                })
        },
        getColunas () {
            this.axios.get(this.url)
                .then(res => {
                    this.colunas = res.data
                    this.montaUrl()
                })
                .catch(err => { alert(error) });
        }
    }
}
</script>
<style scoped>
    .filtro {
        cursor: pointer;
    }
    .td-datatable {
        padding: 5px 12px;
    }
</style>
