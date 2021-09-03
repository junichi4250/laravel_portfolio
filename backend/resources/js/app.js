import './bootstrap'
import Vue from 'vue'
import PortfolioLike from './components/PortfolioLike'
import PortfolioTagsInput from './components/PortfolioTagsInput'
import FollowButton from './components/FollowButton'

const app = new Vue({
    el: '#app',
    components: {
        PortfolioLike,
        PortfolioTagsInput,
        FollowButton,
    }
});
