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

<style>
.mjumbotron {
    padding: 10px;
}

.box-part {
    background: #FFF;
    border-radius: 0;
    padding: 10px 10px;
}

.box-text {
    margin: 10px 0px;
}
</style>