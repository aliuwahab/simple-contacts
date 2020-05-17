<template>
    <div>
        <div v-if="loading"></div>
        <div v-else class="">
            <div v-if="contacts.length === 0">
                No contacts yet. <router-link to="/contacts/create">Start Adding Contacts</router-link>
            </div>

            <div v-for="contact in contacts">
                <router-link :to="'/contacts/'+contact.data.contact_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-400">
                    <UserNameCircle :fullName="contact.data.full_name"></UserNameCircle>
                    <div class="pl-4">
                        <p class="text-blue-400 font-bold">{{ contact.data.full_name}}</p>
                        <p class="text-gray-600">{{ contact.data.company}}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import UserNameCircle from './UserNameCircle';
    export default {
        name: "ListContacts",
        components:{
            UserNameCircle
        },
        data() {
            return {
                loading: true,
                contacts: []
            }
        },
        mounted() {
            axios.get('/api/contacts')
            .then( response => {
                this.contacts = response.data.data
                this.loading = false;
            })
            .catch(errors => {
                this.loading = false;

                alert("Server Error. Unable to fetch your contacts. Check your network and try again!")
            })
        }
    }
</script>

<style scoped>

</style>
