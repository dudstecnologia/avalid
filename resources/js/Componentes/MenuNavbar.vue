<template>
<span>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <div class="container">
            <inertia-link :href="route('dashboard')">
                <b-navbar-brand>AvaliD</b-navbar-brand>
            </inertia-link>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown v-if="$page.auth.admin" text="Cadastro" right>
                        <b-dropdown-item>
                            <inertia-link :href="route('admin.user.index')">Usuário</inertia-link>
                        </b-dropdown-item>
                        <b-dropdown-item>
                            <inertia-link :href="route('admin.avaliacao.index')">Avaliação</inertia-link>
                        </b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item>
                        <inertia-link class="link-simples" v-if="!$page.auth.admin" :href="route('funcionario.user.index')">Perfil</inertia-link>
                    </b-nav-item>

                    <!-- <b-nav-item @click="logout()" right>Sair</b-nav-item> -->

                    <b-nav-item @click="logoutNovo()" right>Sair</b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </div>
    </b-navbar>
    <form id="form-logout" :action="this.route('logout')" method="post">
        <input type="hidden" name="_token" :value="this.$page._token">
    </form>
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
        },
        logoutNovo() {
            document.getElementById('form-logout').submit()
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

    .dropdown-item a:hover, .nav-item a:hover {
        text-decoration: none;
        color: #757575;
    }

    .link-simples {
        color: rgba(255, 255, 255, 0.5);
    }
</style>
