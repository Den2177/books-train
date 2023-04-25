import http from "../http.js";

export default {
    template: `<div class="auth">
                    <form action="#" class="card form vertical g20" @submit.prevent="submit">
                    <h2 class="mini center mb20">Вход</h2>
                    <input type="text" class="input" placeholder="Логин" v-model="fields.login">
                    <input type="password" class="input" placeholder="Пароль" v-model="fields.password">
                    <button class="btn mt">Войти</button>
        </form>
               </div>`,
    data() {
        return {
            fields: {},
        }
    },
    methods: {
        async submit() {
            const response = await http.post('/login', this.fields);
            localStorage.setItem('token', response.token);
            localStorage.setItem('isAdmin', response.isAdmin);
            this.$root.go('MainPage');
        },
    },

}
