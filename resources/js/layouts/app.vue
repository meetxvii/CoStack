<template>
    <div>
        <router-view></router-view>
    </div>    
</template>
<script>

</script>

<style>
    body{
        width: 100vw;
        overflow-x: hidden; 
    }
    ::-webkit-scrollbar {
        width: 10px;
    }
    ::-webkit-scrollbar-track {
        background: #151f32;
    }
    ::-webkit-scrollbar-thumb {
        background: rgb(50 138 241);
        border-radius: 200px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgb(69, 153, 248);
    }

</style>