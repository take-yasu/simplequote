<template>
    <div>
        <button type="button" class="btn btn-primary" @click.prevent="searchConfirm()">検索</button>
        <modal-processing v-show="showProcess"></modal-processing>
    </div>
</template>

<script>
    import ModalProcessing from './ModalProcessing.vue'
    export default{
        components: {
            ModalProcessing,
        },
        data: function(){
            return {
                showProcess: false,
            }
        },
        methods: {
            searchConfirm(){
                document.getElementById('search').submit();
                //this.$refs.form.submit()
                this.showProcess = true
            }
        },
    }
</script>
