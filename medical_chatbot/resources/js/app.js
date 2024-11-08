import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Import the router
import 'bootstrap/dist/css/bootstrap.min.css';



axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Create the Vue application instance
const app = createApp(App);

// Use the router in the application
app.use(router);

// Mount the application to the DOM
app.mount('#app');

