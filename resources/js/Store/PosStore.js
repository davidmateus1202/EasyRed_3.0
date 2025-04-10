import { defineStore } from 'pinia';
import axios from 'axios';

export const usePosStore = defineStore('post', {
    state: () => ({
        posts: [],
        commnets: [],
    }),

    actions: {

        /**
         * index
         */
        async index() {
            try {
                const response = await axios.get(
                    '/api/v1/post/index',
                    {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`
                        }
                    }
                );
                console.log(response)
                if (response.status === 200) {
                    this.posts = [];
                    this.posts = response.data.post.data;
                }

            } catch (e) {
                console.log(e);
            }
        },

        /**
         * create new post
         * @param {Object} formData
         */
        async createPost(formData) {
            try {
                const response = await axios.post(
                    '/api/v1/post/create',
                    formData,
                    {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )

                if (response.status === 201) {
                    let post = response.data.data
                    if (!post.image || post.image === 'null' || post.image === '') {
                        post.image = null;
                    }
                    this.posts.unshift(post);    
                    return false;  
                }
                return true;
            } catch (e) {
                console.log(e);
                return true;
            }
        },

        /**
         * toggle - like post
         * @param {Number} postId
         */
        async toggleReaction(postId) {
            try {
                const response = await axios.post(
                    '/api/v1/post/toggle-reaction',
                    {
                        "post_id": postId
                    },
                    {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        }
                    }
                );

                console.log(response)

                if (response.status === 201) {
                    let post = this.posts.find(post => post.id === postId);
                    if (post) {
                        post.user_reacted = true;
                        post.reaction_count = post.reaction_count + 1;
                    }
                } else if (response.status === 200) {
                    let post = this.posts.find(post => post.id === postId);
                    if (post) {
                        post.user_reacted = false;
                        post.reaction_count = post.reaction_count - 1;
                    }
                }

            } catch (e) {
                console.log(e);
            }
        }
    }
})