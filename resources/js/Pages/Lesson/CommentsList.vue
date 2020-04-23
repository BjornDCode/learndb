<template>
    <ul>
        <li v-for="comment in comments" :key="comment.id" class="mb-4">
            <Comment :comment="comment" />
        </li>
    </ul>
</template>

<script>
    import Comment from '@/Pages/Lesson/Comment'

    export default {
        name: 'CommentsList',

        components: {
            Comment,
        },

        props: {
            comments: {
                type: Array,
                default: () => [],
            },
        },
    }
</script>
