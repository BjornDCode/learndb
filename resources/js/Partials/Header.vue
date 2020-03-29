<template>
    <header>
        <div class="flex justify-between items-center p-4">
            <inertia-link :href="route('home')">
                <Logo class="block h-4" />
            </inertia-link>
            
            <button 
                type="button" 
                class="focus:outline-none focus:shadow-outline"
                @click="toggleMenu"
            >
                <Icon name="menu" class="w-6 h-6 text-blue-900" />
            </button>                
        </div>

        <nav 
            class="border-t border-b border-gray-300"
            :class="{ 'hidden': !menuOpen }"
        >
            <inertia-link 
                :href="route('library')" 
                class="block text-sm text-blue-800 font-medium leading-none px-4 py-3"
            >
                Library
            </inertia-link>
            <inertia-link 
                href="#" 
                class="block text-sm text-blue-800 font-medium leading-none px-4 py-3"
            >
                Profile
            </inertia-link>
            <inertia-link 
                href="#" 
                class="block text-sm text-blue-800 font-medium leading-none px-4 py-3"
            >
                Log out
            </inertia-link>
        </nav>
    </header>
</template>

<script>
    import Logo from '@/components/Logo'
    import Icon from '@/components/Icon'

    export default {
        components: {
            Logo,
            Icon,
        },

        data() {
            return {
                menuOpen: false
            }
        },

        methods: {
            toggleMenu() {
                this.menuOpen = !this.menuOpen
            }
        }
    }
</script>


