<template>
    <div>
        <form @submit.prevent="submitContactForm()">

            <InputTextComponent inputName="first_name" label="First Name" placeholder="Provide first name here" @update:field="form.first_name=$event" :errors="errors"/>

            <InputTextComponent inputName="last_name" label="Last Name" placeholder="Provide last name here" @update:field="form.last_name=$event" :errors="errors"/>

            <InputTextComponent inputName="other_names" label="Other Names" placeholder="Provide the other names" @update:field="form.other_names=$event" :errors="errors"/>

            <InputTextComponent inputName="birth_date" label="Date of Birth" placeholder="Date of birth e.g MM/DD/YYYY" @update:field="form.birth_date=$event" :errors="errors"/>

            <InputTextComponent inputName="company" label="Where does he/she works?" placeholder="Enter company here e.g Alimentar Naya Limited"  @update:field="form.company=$event" :errors="errors"/>

            <InputTextComponent inputName="email" label="Email address" placeholder="Email Address here" @update:field="form.email=$event" :errors="errors"/>

            <InputTextComponent inputName="phone_number" label="Phone Number" placeholder="Enter phone number here" @update:field="form.phone_number=$event" :errors="errors"/>

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
        name: "ContactsCreate",
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

        methods: {
            submitContactForm() {
                axios.post('/api/contacts', this.form)
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
