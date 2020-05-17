<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-blue-400" @click="$router.back()">
                    < Back
                </a>
                <div class="relative">
                    <router-link :to="'/contacts/' + contact.contact_id + '/edit'"
                                 class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 text-sm font-bold mr-2"
                    @click="">
                        Edit
                    </router-link>

                    <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm text-red-500"
                       @click="showDeleteModal = !showDeleteModal">Delete</a>

                    <div class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6"
                         v-if="showDeleteModal">
                        <p>Are you sure you want to delete this contact? </p>
                        <div class="flex items-center mt-6 justify-end">
                            <button class="text-white pr-4" @click="showDeleteModal = !showDeleteModal">Cancel</button>
                            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">
                                Delete
                            </button>
                        </div>
                    </div>

                </div>

                <div v-if="showDeleteModal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="showDeleteModal = !showDeleteModal">

                </div>
            </div>

            <div class="flex items-center pt-6">
                <UserNameCircle :fullName="contact.full_name"/>
                <div class="pl-5 text-xl">
                    {{ contact.full_name}}
                </div>
            </div>

            <p class="pt-6 font-bold uppercase text-sm text-gray-600">Email</p>
            <p>{{ contact.email}}</p>

            <p class="pt-6 font-bold uppercase text-sm text-gray-600">Phone Number</p>
            <p class="pt-2 text-blue-400">{{ contact.phone_number}}</p>

            <p class="pt-6 font-bold uppercase text-sm text-gray-600">Company</p>
            <p class="pt-2 text-blue-400">{{ contact.company}}</p>
            <p class="pt-6 font-bold uppercase text-sm text-gray-600">Birth Day</p>
            <p class="pt-2 text-blue-400">{{ contact.birth_date }}</p>

        </div>
    </div>
</template>

<script>
    import UserNameCircle from "./UserNameCircle";

    export default {
        name: "ContactShow",
        components: {
            UserNameCircle,
        },
        data() {
            return {
                loading: true,
                showDeleteModal: false,
                contact: null
            }
        },
        methods: {
            destroy() {
                axios.delete('/api/contacts/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/contacts')
                    })
                    .catch(error => {
                        alert('Internal Error. Unable to delete contact!')
                    });
            }
        },
        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.contact = response.data.data
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;

                    if (errors.response.status === 404) {
                        this.$router.push("/contacts")
                    }
                });
        }
    }
</script>

<style scoped>

</style>
