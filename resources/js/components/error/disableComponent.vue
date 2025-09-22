<template>
    <div class="error-container">
        <div class="content-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <h2>Esta vista no esta disponible para el empleado</h2>
            <p class="text-danger">Esto sera enviado al administrador con tu IP</p>
            <a href="/" class="btn btn-danger">Volver al inicio</a>
        </div>
    </div>
</template>


<style>
.content-error{
    background-color: rgba(255, 0, 0, 0.479);
    padding: 32px;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    flex-direction: column;
}
.error-container{
    background-color: #000000;
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 3000;
}
.error-container h2{
    color: #fff;
    font-size: 32px;
    font-weight: 600;
    text-align: center;
}
.error-container p{
    color: #aaaaaa !important;
    font-size: 24px;
    font-weight: 600;
    text-align: center;
}
.fa-triangle-exclamation{
    color: #ffff00;
    font-size: 64px;
    text-align: center;
    margin-bottom: 24px;
}

</style>

<script>
export default {
    mounted() {
        const alertSound = new Audio('/sounds/alert.mp3');
        alertSound.play().catch(error => {
            console.warn('Error al reproducir el sonido:', error);
        });
    }
}
</script>


