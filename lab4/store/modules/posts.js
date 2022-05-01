import Axios from "axios";

const state = {
    posts: null,
    chosenPost: null
};

const getters = {
    POSTS: state => {
        return state.posts;
    },
    CHOSEN_POST: state => {
        return state.chosenPost;
    }
};

const mutations = {
    setPosts: (state, payload) => {
        state.posts = payload;
    },
    setChosenPost: (state, payload) => {
        state.chosenPost = payload;
    }
};

const actions = {
    loadPosts: async (context, payload) => {
        await axios.get('/api/posts')
            .then((response) => {
                context.commit('setPosts', response.data.data);
            })
    },
    loadPostById: async (context, id) => {
        await axios.get('/api/posts/' + id)
            .then((response) => {
                context.commit('setChosenPost', response.data.data);
            })
            .catch((error) => {
                console.log(error.response);
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
