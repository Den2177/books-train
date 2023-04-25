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
<div class="flex jcsb mt20">
<button class="btn" @click.prevent="toShowPage(book.id)">Перейти</button>
<div class="number">{{book.score}}</div>
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
        this.books = await http.get('/books');
        console.log(this.books);
    },
    methods: {
        toShowPage(bookId) {
            localStorage.setItem('bookId', bookId);
            this.$root.go('ShowPage');
        }
    },
}
