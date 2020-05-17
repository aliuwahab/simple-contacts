import Vue from 'vue';
import VueRouter from 'vue-router';
import ContactsCreate from "./components/ContactsCreate";
import ContactShow from "./components/ContactShow";
import ContactsEdit from "./components/ContactsEdit";
import AllContacts from "./components/AllContacts";
import CurrentMonthBirthdays from "./components/CurrentMonthBirthdays";
import LogOut from "./Actions/LogOut";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: AllContacts, meta: {title: "Welcome"} },
        { path: '/contacts', component: AllContacts , meta: {title: "All Contacts"}},
        { path: '/contacts/create', component: ContactsCreate , meta: {title: "Add Contact"}},
        { path: '/contacts/:id', component: ContactShow , meta: {title: "Viewing contact"}},
        { path: '/contacts/:id/edit', component: ContactsEdit , meta: {title: "Editing Contact"}},

        { path: '/birthdays', component: CurrentMonthBirthdays , meta: {title: "Current Birthdays"}},


        { path: '/logout', component: LogOut , meta: {title: "Log Out"}}

    ],
    mode: 'history'
})
