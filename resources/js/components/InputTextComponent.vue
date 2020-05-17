<template>
    <div class="relative pb-4">
        <label class="text-blue-500 pt-2 uppercase text-xs font-bold absolute" :for="inputName"> {{ label }}</label>
        <input :id="inputName" v-model="value" type="text"
               class="pt-8 w-full border-b text-gray-900 pb-2 focus:outline-none focus:border-blue-400"
               :class="errorsClassObject(inputName)"
               :placeholder="placeholder" @input="updateField(inputName)">

        <p class="text-red-600 text-sm" v-text="errorMessage(inputName)">Error here...</p>
    </div>
</template>

<script>
    export default {
        name: "InputTextComponent",
        props: [
            'inputName',
            'label',
            'placeholder',
            'errors',
            'data',
        ],
        data() {
            return {
                value: ''
            }
        },
        methods: {
            updateField() {
                this.clearInputError(this.inputName);

                this.$emit('update:field', this.value)
            },

            errorMessage() {
                if (this.hasError) {
                    return this.errors[this.inputName][0];
                }
            },

            clearInputError() {
                if (this.hasError) {
                    return this.errors[this.inputName] = null;
                }
            },

            errorsClassObject(){
                return{
                    'error-field' : this.hasError
                }
            }
        },
        computed: {
            hasError() {
                return this.errors && this.errors[this.inputName] && this.errors[this.inputName].length > 0;
            }
        },
        watch: {
            data(newValue, oldValue) {
                this.value = newValue;
            }
        },
    }
</script>

<style scoped>
    .error-field{
        @apply .border-red-500 .border-b-2
    }
</style>
