<template>
    <Container>
        <Headline>{{ lesson.title }}</Headline>
        <Question
            v-for="question in lesson.content.questions"
            :key="question.id"
            :question="question"
        />
    </Container>
</template>

<script>
    import Headline from '@/Components/Headline'
    import Question from '@/Pages/Lesson/Question'
    import Container from '@/Pages/Lesson/Container'

    export default {
        components: {
            Headline,
            Question,
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
