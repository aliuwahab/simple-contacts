<template>
    <div>
        <ContactsList :endpoint="'/api/birthdays'"/>
    </div>
</template>

<script>
    import ContactsList from "./ContactsList";

    export default {
        name: "CurrentMonthBirthdays",
        components:{
            ContactsList
        }
    }
</script>

