<template>
        <div class="rounded-full border border-gray-400 bg-blue-400 text-white w-10 h-10 flex justify-center items-center">
            {{ userFullNameCircle }}
        </div>
</template>
<script>
    export default {
        name: 'UserNameCircle',
        props: {
            fullName: {
                type: String,
                default: ''
            },
        },
        computed: {
            userFullNameCircle() {
                return this.fullName.match(/[A-Z]/g).slice(0, 2).join('');
            }
        },
    }
</script>
