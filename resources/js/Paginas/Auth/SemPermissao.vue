<template>
    <span>
        <div class="row mt-2">
            <div class="col-md-12">
                <b-jumbotron class="text-center">
                    <h1 class="text-center mb-5">Ops! Sem permissão <i class="fas fa-user-lock"></i></h1>
                    <inertia-link :href="route('dashboard')">
                        <b-button variant="primary" size="sm"><i class="far fa-arrow-alt-circle-left"></i> Voltar para o início</b-button>
                    </inertia-link>
                </b-jumbotron>
            </div>
        </div>
    </span>
</template>

<script>
import Layout from '../../Componentes/Layout'

export default {
    metaInfo: { title: 'Sem permissão' },
    layout: Layout,
}
</script>
