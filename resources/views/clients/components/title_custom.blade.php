
<style>
    .container-title {
        display: flex;
        justify-content: center;

        align-items: center;
        height: 6em; /* Ocupar toda la pantalla */
        position: relative;
        text-align: center;
    }
    /* Texto de fondo (grande y semitransparente) */
    .text-background {
        font-weight: bold;
        font-family:var(--current-font-family);
        color: rgba(0, 0, 0, 0.2); /* Negro con opacidad */
        position: absolute;
    }

    /* Texto principal (más pequeño y encima) */
    .text-foreground {
        font-family:var(--current-font-family);
        font-weight: bold;
        color: black;
        position: absolute;
    }
</style>
<div class="container-title">
    <!-- Texto de fondo -->
    <h1 class="text-background">{{ ucfirst($title) }}</h1>
    <!-- Texto principal -->
    <h4 class="text-foreground">{{ ucfirst($title) }}</h4>
</div>