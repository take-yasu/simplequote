<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>商品コード</th>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>単価</th>
                    <th>小計</th>
                    <th></th>
                </tr>
            </thead>
            <transition-group name="draggingTable" tag="tbody">
                <tr
                    v-for="(row, index) in rows"
                    v-bind:key="row"
                    draggable
                    @dragstart="dragList($event, index)"
                    @drop="dropList($event, index)"
                    @dragover.prevent
                    @dragenter.prevent
                    >
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="product_number[]" @change="searchProduct(row); searchPrice(row)" v-model="ProdNum[row]">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-primary" @click="openModal(row)">検索</button>
                            </div>
                            <!--<button type="button" class="btn btn-outline-primary" @click="openModal(row)">検索</button>-->
                        </div>
                        <search-product v-show="showModal" :row="rowNumber" @close="closeModal" @decide="getNum($event, index)"></search-product>
                    </td>
                    <td><input type="text" class="form-control" name="product_name[]" v-model="ProdNam[row]" readonly></td>
                    <td><input type="text" class="form-control" name="quantity[]" @change="subTotal(row)" v-model="Quant[row]"></td>
                    <td><input type="text" class="form-control" name="unit_price[]" v-model="UnitPr[row]" readonly></td>
                    <td><input type="text" class="form-control" name="subtotal[]" v-model="SubTo[row]" readonly></td>
                    <td><button type="button" class="btn btn-outline-danger" @click="delRow(row)">×</button></td>
                </tr>
            </transition-group>
            <div v-show="showError" class="text-danger small">{{ commentErrors }}</div>
            <button type="button" class="btn btn-outline-primary" @click="addRow">行追加</button>
        </table>
    </div>
</template>

<script>
    import SearchProduct from './SearchProduct.vue'

    export default {
        components: {
            SearchProduct,
        },
        props: {
            loginUser: {},
        },
        data: function(){
            return {
                rows: [0,1,2,3,],
                def: 4,
                ProdNum: [],
                Quant: [],
                ProdNam: [],
                UnitPr: [],
                SubTo: [],
                showError: false,
                commentErrors: null,
                draggingItem: null,
                showModal: false,
                rowNumber: '',
            }
        },
        methods: {
            dragList(e, dragIndex){
                e.dataTransfer.effectAllowed = 'move'
                e.dataTransfer.dropEffect = 'move'
                e.dataTransfer.setData('drag-index', dragIndex)
            },
            dropList(e, dropIndex){
                const dragIndex = e.dataTransfer.getData('drag-index')
                const deleteList = this.rows.splice(dragIndex, 1)
                this.rows.splice(dropIndex, 0, deleteList[0])
            },
            addRow(){
                this.rows.push(this.def);
                this.def++
            },
            delRow(row){
                this.rows.splice(this.rows.findIndex(e => e === row), 1)
            },
            openModal(row){
                this.rowNumber = row
                this.showModal = true
            },
            closeModal(){
                this.showModal = false
            },
            getNum(event, index){
                this.ProdNum[event[1]]= event[0]
                this.searchProduct(event[1])
                this.searchPrice(event[1])
                this.showModal = false
            },
            subTotal(row){
                if (this.UnitPr[row]){
                    let st = this.Quant[row] * this.UnitPr[row]
                    this.$set(this.SubTo, row, st)
                }
            },
            //品名検索
            async searchProduct(row){
                const response = await axios.get(`/api/mitsumori/search/number/${this.ProdNum[row]}`)
                .then(res => {
                    this.$set(this.ProdNam, row, res.data.product_name)
                    if(!res.data.product_name){
                        alert('品番が存在しません')
                        this.$set(this.ProdNum, row, '')
                    }
                })
                .catch(e => {
                    this.commentErrors = e.response.data.errors.comment[0]
                    this.showError = true
                })
            },
            //単価検索
            async searchPrice(row){
                const response = await axios.get(`/api/mitsumori/search/${this.loginUser.user_code}/${this.ProdNum[row]}`)
                .then(res => {
                    this.$set(this.UnitPr, row, res.data.unit_price)
                    if (this.Quant[row]){
                        let st = this.Quant[row] * this.UnitPr[row]
                        this.$set(this.SubTo, row, st)
                    }
                })
                .catch(e => {
                    this.commentErrors = e.response.data.errors.comment[0]
                    this.showError = true
                })
            }
        },
    }
</script>
<style>
.draggingTable-move{
    transition: transform 0.3s;
}
.input-group-append{
    z-index: 1;
}
</style>
