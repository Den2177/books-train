import MainPage from "../pages/MainPage.js";
import RegisterPage from "../pages/RegisterPage.js";
import LoginPage from "../pages/LoginPage.js";
import BooksPage from "../pages/BooksPage.js";
import ShowPage from "../pages/ShowPage.js";
import LikedPage from "../pages/LikedPage.js";

export default {
    components: {MainPage, RegisterPage, LoginPage, BooksPage, ShowPage, LikedPage},
    template: `<div><component :is="pageName"></component></div>`,
    data() {
        return {
            pageName: 'MainPage',
            isTopMode: false,
        }
    },
    created() {
        if (localStorage.getItem('currentPage')) {
            this.pageName = localStorage.getItem('currentPage');
        }
    },
    mounted() {
        window.addEventListener('beforeunload', () => {
            localStorage.setItem('currentPage', this.pageName);
        });
    },
    methods: {
        go(pageName) {
            localStorage.setItem('prevPage', this.pageName);
            this.pageName = pageName;
        },
        isAuth: () => !!localStorage.getItem('token'),
    },
}
