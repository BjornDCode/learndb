<template>
    <div>
        <Headline :level="3">
            {{ question.title }}
        </Headline>
        <ul>
            <li
                v-for="option in question.options"
                :key="option.id"
                class="mb-8"
            >
                <Option
                    :option="option"
                    :disabled="answered"
                    @answer="$emit('answer', $event)"
                />
            </li>
        </ul>
    </div>
</template>

<script>
    import Option from '@/Pages/Lesson/Option'
    import Headline from '@/Components/Headline'

    export default {
        components: {
            Option,
            Headline,
        },

        props: {
            question: {
                type: Object,
                required: true,
            },
        },

        computed: {
            answered() {
                return this.question.options.some(option => option.answered)
            },
        },
    }
</script>
