<template>
    <App>
        <div class="md:flex">
            <Sidebar :items="lessons" :lesson="lesson" :series="series" />

            <main class="flex-1 min-w-0">
                <Component
                    :is="lesson.content.type"
                    :lesson="lesson"
                    :series="series"
                    @finished="recordActivity"
                />
                <Footer
                    :series="series"
                    :lesson="lesson"
                    :resources="resources"
                    :comments="comments"
                />
            </main>
        </div>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Quiz from '@/Pages/Lesson/Quiz'
    import Video from '@/Pages/Lesson/Video'
    import Footer from '@/Pages/Lesson/Footer'
    import Sidebar from '@/Pages/Lesson/Sidebar'
    import Article from '@/Pages/Lesson/Article'

    export default {
        components: {
            App,
            Quiz,
            Video,
            Footer,
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
                default: () => ({}),
            },
            lesson: {
                type: Object,
                default: () => ({}),
            },
            resources: {
                type: Array,
                default: () => [],
            },
            comments: {
                type: Array,
                default: () => [],
            },
        },

        methods: {
            recordActivity() {
                this.$inertia.post(
                    route('activity.store'),
                    {
                        item_id: this.lesson.id,
                        item_type: 'App\\Lesson',
                        type: 'finished',
                    },
                    {
                        preserveState: true,
                        preserveScroll: true,
                    }
                )
            },
        },
    }
</script>
