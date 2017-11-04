<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.info('Author ：https://www.52xckl.cn')
        }
    }
</script>

<style>
    html, body {
        margin: 0;
        padding: 0;
        font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", Arial, sans-serif;
        font-size: 14px;
        width: 100%;
        height: 100%;
        min-width: 992px;
    }

    #app {
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
</style>
