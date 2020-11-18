<template>
    <div>
        <button class="btn btn-outline-danger" @click="openModal()">削除</button>
        <transition name="modal-confirm" appear>
                <div id="overlay-confirm" v-show="showModal">
                    <div id="content-confirm" class="rounded shadow">
                        <div class="modal-header">
                            <h5 class="modal-title">お見積りの削除</h5>
                        </div>
                        <div class="modal-body">
                            <p>本当に削除してよろしいでしょうか？</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-danger submit" @click="deleteQuote()">削除</button>
                            <button class="btn btn-outline-secondary submit" @click="closeModal()">閉じる</button>
                        </div>
                    </div>
                </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props:{
            DenpyouData: {},
        },
        data(){
            return{
                showModal: false,
            }
        },
        methods: {
            closeModal(){
                this.showModal = false
            },
            openModal(){
                this.showModal = true
            },
            async deleteQuote(){
                const response = await axios.post('/api/mitsumori/delete', {denpyou_number:this.DenpyouData.number})
                .then(res => {
                    alert('見積伝票 ' + this.DenpyouData.number + ' を削除しました')
                    this.showModal = false
                    location.href = "http://simplequote/mitsumori/list/search"
                })
                .catch(e => {
                    alert('見積伝票の削除に失敗しました')
                    this.showModal = false
                })
            }
        },
    }
</script>

<style>
#overlay-confirm{
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

#content-confirm{
z-index:2;
height:40%;
width:50%;
padding: 1em;
background-color: #ffffff;
}

.modal-confirm-enter-active, .modal-confirm-leave-active {
    transform: translate(0px, 0px);
    transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;
}

.modal-confirm-enter, .modal-confirm-leave-to {
  transform: translateY(-100vh) translateY(0px);
  opacity: 0;
}

</style>
