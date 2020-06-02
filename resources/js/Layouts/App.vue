<template>
    <div class="antialiased">
        <Header />

        <slot />
    </div>
</template>

<script>
    import Header from '@/Partials/Header'

    export default {
        components: {
            Header,
        },
    }
</script>
