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
        <div class="grid f1f3">
        <div class="sidebars vertical g20">
            <form action="#" class="card vertical g20" @submit.prevent="filter">
                <h3>Фильтрация</h3>
                <input type="text" class="input" placeholder="Средняя оценка От" v-model="fields.scoreFrom">
                <input type="text" class="input" placeholder="Средняя оценка До" v-model="fields.scoreTo">
                <select class="input" name="author_id" v-model="fields.author_id">
                        <option value="null" selected disabled>Автор</option>
                        <option :value="author.id" v-for="author in authors">{{author.name}}</option>
                    </select>
                <select class="input" multiple name="genres" v-model="fields.genres">
                        <option value="null" selected disabled>Жанры</option>
                        <option :value="genre.id" v-for="genre in genres">{{genre.name}}</option>
                </select>
                <h3>Сортировать</h3>
                <select class="input" v-model="fields.sort">
                    <option value="date-up">По дате (возрастание)</option>
                    <option value="date-down">По дате (убывание)</option>
                    <option value="score-up">По среднему баллу оценки (возрастание)</option>
                    <option value="score-down">По среднему баллу оценки (убывание)</option>
</select>
                <button class="btn">Отфильтровать</button>
</form>
</div>
<div class="vertical g20">
            <div class="grid f1f2 book-item" v-for="book in books">
<div class="image">
<img :src="book.image" alt="image">
</div>
<div class="card content">
<h3>
{{book.title}}
</h3>
<div class="text">{{book.text}}</div>
<div class="flex jcsb mt20">
<button class="btn" @click.prevent="toShowPage(book.id)">Перейти</button>
<div class="number">{{book.score}}</div>
</div>
</div>
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
            books: [],
            authors: [],
            genres: [],
            fields: {
                scoreFrom: '',
                scoreTo: '',
                sort: '',
                author_id: '',
                genres: [

                ],
            },
        }
    },
    async mounted() {
        if (this.$root.isTopMode) {
            this.fields.sort = 'score-down';
            this.books = await http.get('/books', this.fields);
        } else {
            this.books = await http.get('/books');
        }
        this.authors = await http.get('/authors');
        this.genres = await http.get('/genres');
    },
    methods: {
        async filter() {
            console.log(this.books);
            console.log(this.books.length);
            const {priceFrom, priceTo, sort, author_id, genres} = this.books;
            /*let queryString = `/books?priceFrom=${priceFrom}&priceTo=${priceTo}&sort=${sort}&author_id=${author_id}`;
            if (genres.length) {
                queryString += `genres[]=`
            }*/
            this.books = await http.get(`/books`, this.fields);
        },
        toShowPage(bookId) {
            localStorage.setItem('bookId', bookId);
            this.$root.go('ShowPage');
        }
    },
}
