<template>
    <form @submit.prevent="$emit('submit', form)">
        <div class="bg-white shadow rounded p-6">
            <textarea
                v-model="form.content"
                id=""
                rows="6"
                class="w-full focus:outline-none"
                placeholder="I think that..."
            ></textarea>
        </div>

        <button
            class="block shadow text-sm font-display font-bold text-blue-100 bg-blue-800 rounded px-6 py-3 transition transition-transform duration-100 transform hover:scale-105 hover:shadow-md mt-4 ml-auto"
        >
            Comment
        </button>
    </form>
</template>

<script>
    export default {
        props: {
            formValues: {
                type: Object,
                default: () => ({}),
            },
        },

        data() {
            return {
                form: {
                    ...this.formValues,
                    content: '',
                },
            }
        },
    }
</script>
