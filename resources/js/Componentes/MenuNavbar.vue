<template>
<span>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <div class="container">
            <b-navbar-brand href="#">AvaliD</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown text="Cadastro" right>
                        <b-dropdown-item>
                            <inertia-link :href="route('admin.user.index')">Usuários</inertia-link>
                        </b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Configurações" right>
                        <b-dropdown-item href="#">E-mail</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item @click="logout()" right>Sair</b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </div>
    </b-navbar>
</span>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    methods: {
        logout() {
            this.$inertia.post(this.route('logout'))
        }
    }
}
</script>

<style>
    .dropdown-item:hover {
        background-color: #fff;
    }

    .dropdown-item a {
        text-decoration: none;
        display: block;
        color: black;
    }

    .dropdown-item a:hover {
        text-decoration: none;
        color: #757575;
    }
</style>
