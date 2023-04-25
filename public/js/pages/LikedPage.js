import HeaderBlock from '../components/HeaderBlock.js';
import FooterBlock from '../components/FooterBlock.js';
import http from "../http.js";

export default {
    components: {HeaderBlock, FooterBlock},
    template: `<div class="wrapper">
<HeaderBlock></HeaderBlock>
<main class="main">
<div class="books">
<div class="container">
<div class="books-body vertical g20">
<div class="grid f1f2 book-item" v-for="book in books">
<div class="image">
<img :src="book.image" alt="image">
</div>
<div class="card content">
<h3>
{{book.title}}
</h3>
<div class="text">{{book.text}}</div>
<div class="vertical g10">
<div class="number center">{{book.score}}</div>
<button class="btn" @click.prevent="toShowPage(book.id)">Перейти</button>
<button class="btn" @click.prevent="dislike(book.id)">Удалить из избранных</button>
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
        }
    },
    async mounted() {
        this.books = await http.get('/liked');
    },
    methods: {
        toShowPage(bookId) {
            localStorage.setItem('bookId', bookId);
            this.$root.go('ShowPage');
        },
        checkIsLike(bookId) {
          return
        },
        async dislike(bookId) {
            const response = await http.get(`/books/${bookId}/like`);
            if (response) {
                this.books = this.books.filter(book => book.id !== bookId);
            }

            this.likedBooks = await http.get('/liked');
        }
    },
}
