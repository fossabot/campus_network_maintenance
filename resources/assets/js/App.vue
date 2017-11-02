<template>
    <div id="app">
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {}
</script>

<style>
    html, body {
        margin: 0;
        padding: 0;
        font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", Arial, sans-serif;
        font-size: 14px;
        width: 100%;
        height: 100%;
    }

    #app {
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
</style>
