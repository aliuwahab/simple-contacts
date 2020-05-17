import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./components/ContactsCreate";
import ContactShow from "./components/ContactShow";
import ContactsEdit from "./components/ContactsEdit";
import ListContacts from "./components/ListContacts";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: ListContacts },
        { path: '/contacts', component: ListContacts },
        { path: '/contacts/create', component: ContactsCreate },
        { path: '/contacts/:id', component: ContactShow },
        { path: '/contacts/:id/edit', component: ContactsEdit },
    ],
    mode: 'history'
})
