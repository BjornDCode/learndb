<template>
    <div>
        {{ series.title }}
    </div>
</template>

<script>
    export default {
        props: {
            series: {
                type: Object,
                default: () => ({})
            }
        }
    }
</script>
