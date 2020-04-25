<template>
    <iframe
        :src="source"
        :width="width"
        :height="height"
        frameborder="0"
        webkitallowfullscreen
        mozallowfullscreen
        allowfullscreen
    ></iframe>
</template>

<script>
    import Player from '@vimeo/player'

    export default {
        components: {
            Player,
        },

        props: {
            source: {
                type: String,
                required: true,
            },
            width: {
                type: Number,
                required: true,
            },
            height: {
                type: Number,
                required: true,
            },
        },

        mounted() {
            this.player = new Player(this.$el)
            this.player.on('ended', () => {
                this.$emit('ended')
            })
        },
    }
</script>
