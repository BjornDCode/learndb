<template>
    <App>
        <div class="md:flex">
            <Sidebar />

            <main>
                // Content
            </main>
        </div>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Sidebar from '@/Pages/Lesson/Sidebar'

    export default {
        components: {
            App,
            Sidebar,
        },
    }
</script>
