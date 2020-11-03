<template>
    <transition name="modal-success" appear>
            <div id="overlay-success" v-show="showModal">
                <div id="content-success" class="rounded shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">お見積りの登録</h5>
                    </div>
                    <div class="modal-body">
                        <p>お見積りの登録が完了いたしました！</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger submit" @click="closeModal()">閉じる</button>
                    </div>
                </div>
            </div>
    </transition>
</template>

<script>
    export default {
        data(){
            return{
                showModal: true,
            }
        },
        methods: {
            closeModal(){
                this.showModal = false
            },
        },
    }
</script>

<style>
#overlay-success{
z-index:1;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background-color:rgba(0, 0, 0, 0.2);
display: flex;
align-items: center;
justify-content: center;
}

#content-success{
z-index:2;
height:40%;
width:50%;
padding: 1em;
background-color: #ffffff;
}

.modal-success-enter-active, .modal-success-leave-active {
    transform: translate(0px, 0px);
    transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;
}

.modal-success-enter, .modal-success-leave-to {
  transform: translateY(-100vh) translateY(0px);
  opacity: 0;
}

</style>
