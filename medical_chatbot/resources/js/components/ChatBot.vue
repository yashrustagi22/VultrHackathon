<template>
    <div v-if="isAuthenticated">
        <h2>Chat with the Bot</h2>
        <input type="file" @change="handleFileUpload" />
        <div v-for="message in messages" :key="message.id">{{ message }}</div>
        <input v-model="message" @keyup.enter="sendMessage" placeholder="Type a message" />
    </div>
    <div v-else>
        <p>Please <a href="/login">login</a> to access the chatbot.</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isAuthenticated: false,
            messages: [],
            message: '',
            file: null
        };
    },
    methods: {
        checkAuthentication() {
            axios.get('/api/user').then(response => {
                this.isAuthenticated = response.data.authenticated;
            });
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
            const formData = new FormData();
            formData.append('image', this.file);

            axios.post('/ocr/upload', formData).then(response => {
                this.messages.push('OCR Text: ' + response.data.text);
            });
        },
        sendMessage() {
            axios.post('/chat/send', { message: this.message }).then(response => {
                this.messages.push('Bot: ' + response.data.response);
            });
            this.message = '';
        }
    },
    mounted() {
        this.checkAuthentication();
    }
};
</script>

<style scoped>
    /* Add custom styles for responsive UI */
</style>
