<template>
    <div class="min-h-screen bg-indigo-100 p-8">
        <div class="max-w-sm mx-auto">
            <Headline>Login</Headline>
            <form @submit.prevent="submit">
                <input
                    v-model="form.email"
                    type="email"
                    class="block w-full bg-white rounded px-4 py-3 shadow focus:outline-none focus:shadow-outline "
                    name="email"
                    required
                    autocomplete="email"
                    autofocus
                    placeholder="Email"
                />

                <input
                    v-model="form.password"
                    type="password"
                    class="block w-full bg-white rounded px-4 py-3 shadow focus:outline-none focus:shadow-outline mt-8"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />

                <div class="flex justify-end">
                    <Button type="submit" class=" mt-8">
                        Login
                    </Button>
                </div>
            </form>

            <Card class="p-8 mt-8">
                <p class="text-gray-700">
                    This is a demo version. Login with
                    <code class="bg-blue-100 text-blue-800 text-sm px-2 py-1"
                        >test@test.com</code
                    >
                    and
                    <code class="bg-blue-100 text-blue-800 text-sm px-2 py-1"
                        >password</code
                    >
                </p>
            </Card>
        </div>
    </div>
</template>

<script>
    import Card from '@/Components/Card'
    import Button from '@/Components/Button'
    import Headline from '@/Components/Headline'

    export default {
        components: {
            Card,
            Button,
            Headline,
        },

        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('login'), this.form)
            },
        },
    }
</script>
