<template>
    <ScrollObserver :threshold="0.7" @leave="$emit('finished')">
        <Container>
            <Markdown :content="lesson.content.content" />
        </Container>
    </ScrollObserver>
</template>

<script>
    import Markdown from '@/Components/Markdown'
    import Container from '@/Pages/Lesson/Container'
    import ScrollObserver from '@/Components/ScrollObserver'

    export default {
        components: {
            Markdown,
            Container,
            ScrollObserver,
        },

        props: {
            lesson: {
                type: Object,
                required: true,
            },
        },
    }
</script>
