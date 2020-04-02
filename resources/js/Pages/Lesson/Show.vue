<template>
    <App>
        <div class="md:flex">
            <Sidebar :items="lessons" :lesson="lesson" :series="series" />

            <main class="flex-1 min-w-0">
                <Component :is="lesson.content.type" :lesson="lesson" />
            </main>
        </div>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Quiz from '@/Pages/Lesson/Quiz'
    import Video from '@/Pages/Lesson/Video'
    import Sidebar from '@/Pages/Lesson/Sidebar'
    import Article from '@/Pages/Lesson/Article'

    export default {
        components: {
            App,
            Quiz,
            Video,
            Sidebar,
            Article,
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
