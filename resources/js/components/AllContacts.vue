<template>
    <div>
        <ContactsList :endpoint="'/api/contacts'"/>
    </div>
</template>

<script>
    import ContactsList from "./ContactsList";

    export default {
        name: "AllContacts",
        components:{
            ContactsList
        }
    }
</script>

