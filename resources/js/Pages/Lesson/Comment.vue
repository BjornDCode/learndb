<template>
    <div>
        <div class="flex items-center">
            <div class="w-12 h-12 overflow-hidden rounded-full mr-4">
                <img :src="image" :alt="comment.author.name" />
            </div>
            <div class="flex-1">
                <div class="bg-white rounded shadow p-6">
                    <span class="text-gray-700">
                        {{ comment.content }}
                    </span>
                </div>
                <div class="flex items-center justify-between px-6 py-2">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">
                            {{ comment.created_at }} days ago by
                            {{ comment.author.name }}
                        </span>
                    </div>
                    <button class="text-gray-600 text-sm" @click="toggleForm">
                        Reply
                    </button>
                </div>
            </div>
        </div>

        <slot
            name="footer"
            :children="comment.children"
            :replying="replying"
            :submit="submit"
        />
    </div>
</template>

<script>
    export default {
        props: {
            comment: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                replying: false,
            }
        },

        computed: {
            image() {
                return `https://www.gravatar.com/avatar/${this.comment.author.email_hash}`
            },
        },

        methods: {
            toggleForm() {
                this.replying = !this.replying
            },

            submit(event) {
                this.$emit('comment', event)
                this.toggleForm()
            },
        },
    }
</script>
