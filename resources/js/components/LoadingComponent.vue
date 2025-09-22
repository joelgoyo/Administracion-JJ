<template>
    <div v-if="modelValue" class="loader-container">
        <div class="loader"></div>
    </div>
</template>

<style scoped>
.loader-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    display: flex;
}

.loader {
    border: 8px solid #f3f3f3; /* Gris claro */
    border-top: 8px solid #3498db; /* Azul */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

<script>
export default {
    props: {
        modelValue: {
            type: Boolean,
            default: true,
        },
    },
};
</script>
