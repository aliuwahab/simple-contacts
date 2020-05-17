import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./components/ContactsCreate";
import ContactShow from "./components/ContactShow";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: ExampleComponent },
        { path: '/contacts/create', component: ContactsCreate },
        { path: '/contacts/:id', component: ContactShow },
    ],
    mode: 'history'
})
