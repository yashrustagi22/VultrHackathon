import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue'; // Adjust the path as needed
import Chatbot from '../components/ChatBot.vue'; // Import the Chatbot component

const routes = [
  { path: '/login', component: Login },
  { path: '/home', beforeEnter() { window.location.href = '/home'; } },
  { path: '/chat', component: Chatbot }, // Route for the Chatbot component
  // Add other routes as needed
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
