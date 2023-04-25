import HeaderBlock from '../components/HeaderBlock.js';
import FooterBlock from '../components/FooterBlock.js';
import http from "../http.js";

export default {
    template: `<div class="auth">
                    <form action="#" class="card form vertical g20" @submit.prevent="submit">
                    <h2 class="mini center mb20">Регистрация</h2>
                    <input type="text" class="input" placeholder="Логин" v-model="fields.login">
                    <input type="password" class="input" placeholder="Пароль" v-model="fields.password">
                    <input type="password" class="input" placeholder="Повтор пароля" v-model="fields.password_confirmation">
                    <button class="btn mt">Зарегистрироваться</button>
</form>
               </div>`,
    components: {HeaderBlock, FooterBlock},
    data() {
        return {
            books: [],
            fields: {},
        }
    },
    async mounted() {
        console.log(this.books);
    },
    methods: {
        async submit() {
            const response = await http.post('/register', this.fields);
            this.$root.go('LoginPage');
        },
    },

}
