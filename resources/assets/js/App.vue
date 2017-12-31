<template>
    <div id="app">
        <router-view/>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.info('Github ：https://github.com/StarUDream/campus_network_maintenance')
            if (window.location.href.indexOf(window.location.origin + '/admin#') !== -1) {
                const href = window.location.href.split('#', 2)
                if (href.length === 2) {
                    window.location.href = href[0] + '/#' + href[1]
                }
            }
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
        min-height: 100%;
    }

    #app {
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
</style>
