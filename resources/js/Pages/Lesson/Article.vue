<template>
    <div class="px-4 py-12 md:px-12 lg:max-w-3xl">
        <Markdown :content="lesson.content.content" />
    </div>
</template>

<script>
    import Markdown from '@/Components/Markdown'

    export default {
        components: {
            Markdown,
        },

        props: {
            lesson: {
                type: Object,
                required: true,
            },
        },

        mounted() {
            console.log(this.lesson)
        },
    }
</script>
