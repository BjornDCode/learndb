<template>
    <Container>
        <Markdown :content="lesson.content.content" />
    </Container>
</template>

<script>
    import Markdown from '@/Components/Markdown'
    import Container from '@/Pages/Lesson/Container'

    export default {
        components: {
            Markdown,
            Container,
        },

        props: {
            lesson: {
                type: Object,
                required: true,
            },
        },
    }
</script>
