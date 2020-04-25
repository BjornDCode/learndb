<template>
    <Container>
        <Headline>{{ lesson.title }}</Headline>
        <Question
            v-for="question in lesson.content.questions"
            :key="question.id"
            :question="question"
            @answer="answer"
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
            series: {
                type: Object,
                default: () => [],
            },
        },

        computed: {
            finished() {
                return this.lesson.content.questions.every(question => {
                    return question.options.some(option => option.answered)
                })
            },
        },

        methods: {
            answer(optionId) {
                this.$inertia.post(
                    route('answers.store', {
                        series: this.series.slug,
                        lesson: this.lesson.slug,
                    }),
                    {
                        option_id: optionId,
                    },
                    {
                        preserveState: true,
                        preserveScroll: true,
                    }
                )
            },
        },

        watch: {
            finished() {
                if (this.finished) {
                    this.$emit('finished')
                }
            },
        },
    }
</script>
