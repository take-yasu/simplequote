<template>
    <transition name="modal-search" appear>
        <div id="overlay">
            <div id="content" class="rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">品番検索</h5>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="searchNumber()" class="form-horizontal">
                        <div class="input-group form-group form-row">
                            <label class="col-form-label col-sm-2" for="productName">品名</label>
                            <input class="form-control col-sm-8" type="text" v-model="productName" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary">検索</button>
                            </div>
                        </div>
                    </form>
                    <div v-show="showError" class="text-danger small">{{ commentErrors }}</div>
                    <div v-show="showProduct" class="table-wrap">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th>品名</th>
                                <th>品番</th>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in productNames" :key="product.product_number" @click="decideNum(product.product_number)">
                                    <td>{{product.product_name}}</td>
                                    <td>{{product.product_number}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" @click.prevent="closeModal()">キャンセル</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        //name: SearchProduct,
        props:['row'],
        data(){
            return{
                num: '',
                productName: '',
                productNames: {},
                showProduct: false,
                showError: false,
                commentErrors: ''
            }
        },
        methods: {
            closeModal(){
                this.$emit('close')
                this.productName = ''
                this.productNames = {}
                this.showProduct = false
                this.showError = false
            },
            decideNum(product_number){
                this.$emit('decide', [product_number, this.row])
                this.productName = ''
                this.productNames = {}
                this.showProduct = false
                this.showError = false
            },
            async searchNumber(){
                const response = await axios.get(`/api/mitsumori/search/name/${this.productName}`)
                .then(res => {
                    this.productNames = res.data
                    console.log(Object.keys(this.productNames).length)
                    console.log(this.showProduct)
                    if(Object.keys(this.productNames).length > 0){
                        this.showProduct = true
                    }
                    console.log(this.showProduct)
                })
                .catch(e => {
                    this.commentErrors = e.response.data.errors
                    this.showError = true
                    this.showProduct = false
                })
            }
        },

    }
</script>

<style>
 #overlay{
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

#content{
  z-index:2;
  height:60%;
  width:50%;
  padding: 1em;
  background-color: #ffffff;
}

.modal-search-enter-active, .modal-search-leave-active {
  transition:opacity 0.5s;
}

.modal-search-enter, .modal-search-leave-to {
  opacity: 0;
}

.table-wrap {
    height: 120px;
    overflow-y: auto;
}
</style>
