<template>
    <transition name="modal-processing" appear>
        <div id="overlay-processing">
            <div id="content-processing" class="rounded shadow">
                <div class="modal-header">
                    <h5>処理中</h5>
                </div>
                <div class="modal-body">
                    <p>処理中です。しばらくお待ちください。</p>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'ModalProcessing',
    }
</script>
<style>
#overlay-processing{
z-index:9;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background-color:rgba(0, 0, 0, 0.2);
display: flex;
align-items: flex-start;
justify-content: center;
}
#content-processing{
z-index:10;
height:20%;
width:40%;
margin: 1em;
background-color: #ffffff;
}

.modal-processing-enter-active, .modal-processing-leave-active {
    transform: translate(0px, 0px);
    transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;
}
.modal-processing-enter, .modal-processing-leave-to {
  transform: translateY(-100vh) translateY(0px);
  opacity: 0;
}
</style>
