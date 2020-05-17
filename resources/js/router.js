import Vue from 'vue';
import VueRouter from 'vue-router';
import ContactsCreate from "./components/ContactsCreate";
import ContactShow from "./components/ContactShow";
import ContactsEdit from "./components/ContactsEdit";
import AllContacts from "./components/AllContacts";
import CurrentMonthBirthdays from "./components/CurrentMonthBirthdays";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: AllContacts },
        { path: '/contacts', component: AllContacts },
        { path: '/contacts/create', component: ContactsCreate },
        { path: '/contacts/:id', component: ContactShow },
        { path: '/contacts/:id/edit', component: ContactsEdit },

        { path: '/birthdays', component: CurrentMonthBirthdays },
    ],
    mode: 'history'
})
