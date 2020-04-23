<template>
    <div class="border-t border-gray-300">
        <div
            class="px-4 py-12 md:px-12 flex flex-col-reverse lg:flex-row lg:max-w-6xl"
        >
            <div class="lg:w-3/4">
                <Headline :level="3">
                    Comments
                </Headline>

                <CommentsList :comments="comments" />

                <div>
                    <Headline :level="4">
                        Add a comment
                    </Headline>

                    <CommentForm
                        :form-values="{ lesson_id: this.lesson.id }"
                        @submit="comment"
                    />
                </div>
            </div>
            <div class="lg:w-1/4 lg:ml-8">
                <Headline :level="3">
                    Resources
                </Headline>

                <ul>
                    <li v-for="resource in resources" :key="resource.url">
                        <a
                            target="_blank"
                            :href="resource.url"
                            class="block text-lg text-gray-800 underline mb-2"
                        >
                            {{ resource.title }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Headline from '@/Components/Headline'
    import CommentForm from '@/Pages/Lesson/CommentForm'
    import CommentsList from '@/Pages/Lesson/CommentsList'

    export default {
        components: {
            Headline,
            CommentForm,
            CommentsList,
        },

        props: {
            series: {
                type: Object,
                required: true,
            },
            lesson: {
                type: Object,
                required: true,
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
            comment(data) {
                this.$inertia.post(
                    route('comment.store', {
                        series: this.series.slug,
                        lesson: this.lesson.slug,
                    }),
                    data,
                    {
                        preserveState: true,
                        preserveScroll: true,
                    }
                )
            },
        },
    }
</script>
