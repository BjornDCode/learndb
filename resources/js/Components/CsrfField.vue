<template>
    <input type="hidden" name="_token" :value="csrf" />
</template>

<script>
    export default {
        data() {
            return {
                csrf: this.$page.app.csrfToken,
            }
        },
    }
</script>
