<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
        </div>
        <form @submit.prevent="submitContactForm()">

            <InputTextComponent inputName="first_name" label="First Name" placeholder="Provide first name here" @update:field="form.first_name=$event" :errors="errors" :data="form.first_name"/>

            <InputTextComponent inputName="last_name" label="Last Name" placeholder="Provide last name here" @update:field="form.last_name=$event" :errors="errors" :data="form.last_name"/>

            <InputTextComponent inputName="other_names" label="Other Names" placeholder="Provide the other names" @update:field="form.other_names=$event" :errors="errors" :data="form.other_names"/>

            <InputTextComponent inputName="birth_date" label="Date of Birth" placeholder="Date of birth e.g MM/DD/YYYY" @update:field="form.birth_date=$event" :errors="errors" :data="form.birth_date"/>

            <InputTextComponent inputName="company" label="Where does he/she works?" placeholder="Enter company here e.g Alimentar Naya Limited"  @update:field="form.company=$event" :errors="errors" :data="form.company"/>

            <InputTextComponent inputName="email" label="Email address" placeholder="Email Address here" @update:field="form.email=$event" :errors="errors" :data="form.email"/>

            <InputTextComponent inputName="phone_number" label="Phone Number" placeholder="Enter phone number here" @update:field="form.phone_number=$event" :errors="errors" :data="form.phone_number"/>

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:bg-red-700">
                    Cancel
                </button>

                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">
                    Add new contact
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputTextComponent from "./InputTextComponent";

    export default {
        name: "ContactsEdit",
        components: {
            InputTextComponent
        },
        data() {
            return {
                form: {
                    first_name: "",
                    last_name: "",
                    other_names: "",
                    birth_date: "",
                    company: "",
                    phone_number: "",
                    email: "",
                },
                errors: null
            }
        },

        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    let fullNameSplit = response.data.data.full_name.split(" ");
                    this.form.first_name = fullNameSplit[0];
                    this.form.last_name = fullNameSplit[1];
                    this.form.other_names = fullNameSplit[2]
                    this.form.phone_number = response.data.data.phone_number
                    this.form.company = response.data.data.company
                    this.form.birth_date = response.data.data.birth_date
                    this.form.email = response.data.data.email
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;

                    if (errors.response.status === 404) {
                        this.$router.push("/contacts")
                    }
                });
        },

        methods: {
            submitContactForm() {
                axios.patch('/api/contacts/'+this.$route.params.id, this.form)
                .then(response =>  {
                    this.$router.push(response.data.links.self)
                    console.log(response.data)
                })
                .catch(errors =>{
                    this.errors = errors.response.data.errors
                });
            }
        },
    }

</script>

<style scoped>

</style>
