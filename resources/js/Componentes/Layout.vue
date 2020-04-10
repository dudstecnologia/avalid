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
    },
    watch: {
        '$page.flash'() {
            if (this.$page.flash.success) {
                this.$swal({
                    icon: 'success',
                    text: this.$page.flash.success
                })
            }
            if (this.$page.flash.error) {
                this.$swal({
                    icon: 'error',
                    text: this.$page.flash.error
                })
            }
        }
    }
}
</script>
