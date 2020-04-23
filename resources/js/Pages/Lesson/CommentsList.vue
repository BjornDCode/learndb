<template>
    <ul>
        <li v-for="comment in comments" :key="comment.id" class="mb-4">
            <Comment :comment="comment">
                <template #footer="{ children }">
                    <div class="ml-12" v-if="children.length">
                        <CommentsList :comments="children" />
                    </div>
                </template>
            </Comment>
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
