<template>
    <div>
        <button type="button" id="clear" class="btn btn-secondary" @click="clearData">クリア</button>
    </div>
</template>

<script>
    export default {
        methods: {
            clearData(){
                const inputs = document.querySelectorAll('.form-control')
                inputs.forEach(function(item, index){
                    item.value = ''
                })
            }
        },
    }
</script>
