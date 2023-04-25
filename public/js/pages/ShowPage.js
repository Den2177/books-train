import HeaderBlock from '../components/HeaderBlock.js';
import FooterBlock from '../components/FooterBlock.js';
import http from "../http.js";

export default {
    components: {HeaderBlock, FooterBlock},
    template: `<div class="wrapper">
<HeaderBlock></HeaderBlock>
<main class="main">
    <div class="books-page">
    <div class="container">
        <div class="grid f1f2 g20" v-if="book">
        <div class="contain-image">
            <img :src="book.image" alt="">
</div>
        <div class="card vertical g10">
        <h2 class="mini">{{book.title}}</h2>
        <div class="text">{{book.text}}</div>
        <div class="flex g10">
        <span>Автор: </span>
        <span>{{book.author.name}}</span>
</div>
        <div class="flex g10">
        <span>Жанры: </span>
        <div class="flex g5">
        <div class="genre-item" v-for="genre in book.genres">
        <span>{{genre.name}} / </span>
</div>
</div>

</div>
        <div class="flex g10">
        <span>Средняя оценка: </span>
        <div class="number">
        {{book.score}}
</div>
</div>
        <select class="input" v-if="$root.isAuth() && showScorePanel" v-model="selectedBookId">
        <option value="0" selected disabled>Выбрать оценку</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>

</select>
<button class="btn" @click="setScore" v-if="showScorePanel">Выставить оценку</button>
        <button class="btn" v-if="$root.isAuth() && !isLiked" @click.prevent="likeBook()">Добавить в избранное</button>
</div>
</div>
</div>
    </div>
    </div>
</main>
<FooterBlock></FooterBlock>
</div>`,
    data() {
        return {
            book: null,
            bookId: localStorage.getItem('bookId'),
            likedBooks: [],
            selectedBookId: '',
            showScorePanel: false,
        }
    },
    async mounted() {
        if (localStorage.getItem('token')) {
            this.likedBooks = await http.get('/liked');
        }

        this.book = await http.get(`/books/${this.bookId}/show`);
        const response = await http.get(`/books/${this.bookId}/may-set`)
        this.showScorePanel = response.result;
    },
    computed: {
        isLiked() {
            return this.likedBooks.map(i => i.id).includes(+this.bookId)
        }
    },
    methods: {
        async likeBook() {
            const response = await http.get(`/books/${this.bookId}/like`);
            this.likedBooks = await http.get('/liked');
        },
        async setScore() {
            const response = await http.post(`/books/${this.bookId}/set-score`, {
                value: this.selectedBookId,
            });
            this.book = await http.get(`/books/${this.bookId}/show`);
            this.showScorePanel = false;
        },
    },
}
