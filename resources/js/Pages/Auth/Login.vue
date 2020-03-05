<template>
    <form @submit.prevent="submit">
        <input v-model="form.email" placeholder="Email" type="email" />
        <input v-model="form.password" placeholder="Senha" type="password" />
        <button class="btn-indigo" type="submit">Login</button>
    </form>
</template>

<script>
export default {
//   metaInfo: { title: 'Login' },
  props: {
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        email: '',
        password: ''
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post(this.route('login.attempt'), {
        email: this.form.email,
        password: this.form.password
      }).then(() => {
          console.log('Logou com sucesso')
      })
    },
  },
}
</script>
