<style>
    body {
        height: 100vh;
        background-color: #eeeeee;
    }

    section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        transform: translateY(-5%);
    }
</style>

<section>
    <h1>Error 500</h1>
    <p>
        <?= $message ?>
    </p>
</section>