<template>
    <div>
        <Header />

        <slot />
    </div>
</template>

<script>
    import Header from '@/partials/Header'

    export default {
        components: {
            Header,
        }
    }
</script>
