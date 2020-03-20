<template>
    <div>
        <menu-navbar />

        <div class="container">
            <slot />
        </div>
    </div>
</template>

<script>
import MenuNavbar from '../Componentes/MenuNavbar'
export default {
    components: {
        MenuNavbar
    },
    data() {
        return {

        }
    }
}
</script>
