export default {
    template: `<header class="header">
<div class="container">
<a href="#" class="logo" @click.prevent="$root.go('MainPage')">Logo</a>
<div class="flex g40">

<nav class="flex g20">
<a href="#" class="link" v-if="$root.isAuth()" @click.prevent="$root.go('LikedPage')">Избранные книги</a>
<a href="#" class="link" @click.prevent="toTopBooks">Топ книг</a>
</nav>
<div class="flex g5" v-if="!$root.isAuth()">
<button class="btn" @click="$root.go('LoginPage')">Вход</button>
<button class="btn" @click="$root.go('RegisterPage')">Регистрация</button>
</div>
</div>
</div>

</header>`,
    data() {
        return {
        }
    },
    mounted() {
        console.log(this.$root.isAuth());
    },
    methods: {
        toTopBooks() {
            this.$root.isTopMode = true;
            this.$root.go('BooksPage');
        }
    },
}
