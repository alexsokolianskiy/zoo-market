/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';
import CategoryComponent from './components/admin/Category.vue'

import { createApp } from 'vue';

const app = createApp({});
app.component('categories', CategoryComponent);
app.mount('#app');