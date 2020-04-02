<template>
    <App>
        <div class="md:flex">
            <Sidebar :items="lessons" :lesson="lesson" :series="series" />

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

        props: {
            lessons: {
                type: Array,
                default: () => [],
            },
            series: {
                type: Object,
                default: () => [],
            },
            lesson: {
                type: Object,
                default: () => [],
            },
        },
    }
</script>
