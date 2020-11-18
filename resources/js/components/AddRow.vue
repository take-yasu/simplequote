<template>
    <div>
        <form :action="loginUser.route" method="post" ref="form" id="create" @submit.prevent="checkForm()">
            <input type="hidden" name="_token" :value="csrf">
            <!--見積ヘッダー部-->
                <slot></slot>
            <!--見積明細部-->
            <table class="table">
                <thead>
                    <tr>
                        <th>商品コード</th>
                        <th>商品名</th>
                        <th>数量</th>
                        <th>単位</th>
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
                            </div>
                            <search-product v-show="showModal" :row="rowNumber" @close="closeModal" @decide="getNum($event, index)"></search-product>
                        </td>
                        <td><input type="text" class="form-control" name="product_name[]" v-model="ProdNam[row]" readonly></td>
                        <td><input type="text" class="form-control" name="quantity[]" @change="subTotal(row)" v-model="Quant[row]"></td>
                        <td><input type="text" class="form-control" name="unit[]" v-model="Uni[row]" readonly></td>
                        <td><input type="text" class="form-control" name="unit_price[]" v-model="UnitPr[row]" readonly></td>
                        <td><input type="text" class="form-control" name="subtotal[]" v-model="SubTo[row]" readonly></td>
                        <td><button type="button" class="btn btn-outline-danger" @click="delRow(row)">×</button></td>
                    </tr>
                </transition-group>
                <div v-show="showError" class="text-danger small">{{ commentErrors }}</div>
                <button type="button" class="btn btn-outline-primary" @click="addRow">行追加</button>
            </table>
            <button type="submit" class="btn btn-primary">確認</button>
        </form>
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
            old: {},
            items: {},
        },
        data: function(){
            return {
                rows: Array(),
                def: 4,
                ProdNum: [],
                Quant: [],
                ProdNam: [],
                Uni: [],
                UnitPr: [],
                SubTo: [],
                showError: false,
                commentErrors: null,
                draggingItem: null,
                showModal: false,
                rowNumber: '',
                ErrNum: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
            checkForm(){
                let self = this
                this.checkNum()
                .then(function(){
                    console.log('繰り返しの後')
                    console.log(self.ErrNum)
                    if(!self.ErrNum){
                        self.$refs.form.submit()
                    }else{
                        self.ErrNum = false
                    }
                })
            },
            async checkNum(){
                this.ErrNum = false
                console.log(this.ErrNum)
                for(let i = 0; i < this.def; i++){
                    if(this.ProdNum[i]){
                        await this.searchProduct(i)
                        console.log(this.ErrNum)
                        if(this.ErrNum){
                            console.log('breakします')
                            break
                        }
                    }
                }
            },
            //品名検索
            async searchProduct(row){
                const response = await axios.get(`/api/mitsumori/search/number/${this.ProdNum[row]}`)
                .then(res => {
                    this.$set(this.ProdNam, row, res.data.product_name)
                    this.$set(this.Uni, row, res.data.unit)
                    console.log(res.data.product_name)

                    if(!res.data.product_name){
                        this.$set(this.ProdNum, row, '')
                        this.$set(this.ProdNam, row, '')
                        this.$set(this.Uni, row, '')
                        this.ErrNum = true
                        console.log('品番が存在しません')
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
            },
        },
        created(){
            if(this.old.product_number){
                //前回入力値の呼び出し
                let len = Object.keys(this.old.product_name).length
                for(let i = 0; i < len; i++){
                    this.rows.push(i)
                }
                let items = this.old.product_number
                items.forEach(element => {
                  this.ProdNum.push(element)
                });
            }else if(this.items){
                //既存見積の修正時
                let len = Object.keys(this.items.details).length
                for(let i = 0; i < len; i++){
                    this.rows.push(i)
                }
                let numbers = this.items.details.map(value => value.product_number);
                numbers.forEach(element => {
                    this.ProdNum.push(element)
                });
                let names = this.items.details.map(value => value.product_name);
                names.forEach(element => {
                    this.ProdNam.push(element)
                });
                let quantities = this.items.details.map(value => value.quantity);
                quantities.forEach(element => {
                    this.Quant.push(element)
                });
                let units = this.items.details.map(value => value.unit);
                units.forEach(element => {
                    this.Uni.push(element)
                });
                let unit_prices = this.items.details.map(value => value.unit_price);
                unit_prices.forEach(element => {
                    this.UnitPr.push(element)
                });
                let subtotals = this.items.details.map(value => value.subtotal);
                subtotals.forEach(element => {
                    this.SubTo.push(element)
                });
            }else{
                //新規入力時
                let len = this.def
                for(let i = 0; i < len; i++){
                    this.rows.push(i)
                }
            }

            if(this.old.quantity){
                let items = this.old.quantity
                items.forEach(element => {
                    this.Quant.push(element)
                });
            }
            if(this.old.unit){
                let items = this.old.unit
                items.forEach(element => {
                    this.Uni.push(element)
                });
            }
            if(this.old.product_name){
                let items = this.old.product_name
                items.forEach(element => {
                    this.ProdNam.push(element)
                });
            }
            if(this.old.unit_price){
                let items = this.old.unit_price
                items.forEach(element => {
                    this.UnitPr.push(element)
                });
            }
            if(this.old.subtotal){
                let items = this.old.subtotal
                items.forEach(element => {
                    this.SubTo.push(element)
                });
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
