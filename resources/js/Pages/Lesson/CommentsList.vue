<template>
    <ul>
        <li v-for="comment in comments" :key="comment.id" class="mb-4">
            <Comment :comment="comment" @comment="$emit('comment', $event)">
                <template #footer="{ children, replying, submit }">
                    <div class="ml-12">
                        <CommentsList
                            v-if="children.length"
                            :comments="children"
                            @comment="$emit('comment', $event)"
                        />

                        <div v-if="replying">
                            <CommentForm
                                :form-values="{ parent_id: comment.id }"
                                @submit="submit($event)"
                                class="ml-4"
                            />
                        </div>
                    </div>
                </template>
            </Comment>
        </li>
    </ul>
</template>

<script>
    import Comment from '@/Pages/Lesson/Comment'
    import CommentForm from '@/Pages/Lesson/CommentForm'

    export default {
        name: 'CommentsList',

        components: {
            Comment,
            CommentForm,
        },

        props: {
            comments: {
                type: Array,
                default: () => [],
            },
        },
    }
</script>
