<template>
    <div>
        <VideoPlayer
            :source="lesson.content.url"
            :width="videoSize.width"
            :height="videoSize.height"
            @ended="$emit('finished')"
        />
        <Container>
            <Headline>
                {{ lesson.title }}
            </Headline>
            <Markdown :content="lesson.content.description" />
        </Container>
    </div>
</template>

<script>
    import Headline from '@/Components/Headline'
    import Markdown from '@/Components/Markdown'
    import Container from '@/Pages/Lesson/Container'
    import VideoPlayer from '@/Components/VideoPlayer'

    export default {
        components: {
            Headline,
            Markdown,
            Container,
            VideoPlayer,
        },

        props: {
            lesson: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                videoSize: {
                    width: 0,
                    height: 0,
                },
            }
        },

        mounted() {
            this.videoSize.width = this.$el.clientWidth
            this.videoSize.height = (this.videoSize.width / 16) * 9
        },
    }
</script>
